<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\ProductAttriBute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Viewer;
use Carbon\Carbon;
use App\Models\Customer;

class HomeController extends Controller
{
    // Chuyển đến trang chủ
    public function index()
    {
        // Kiểm tra trạng thái đăng nhập và trạng thái tài khoản
        if (Session::has('idCustomer')) {
            $idCustomer = Session::get('idCustomer');
            $customer = Customer::find($idCustomer);

            if ($customer && $customer->Status == 0) {
                // Nếu tài khoản bị khóa, hiển thị SweetAlert, đăng xuất tài khoản và chuyển hướng về trang login
                Session::put('idCustomer', null);
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị khóa');
            }
        }

        // Tiếp tục lấy dữ liệu cho trang chủ
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_blog = Blog::where('Status', '1')->get();
        $recommend_pds_arrays = [];

        $sub30days = Carbon::now()->subDays(30)->toDateString();

        if (Session::get('idCustomer') == '') $idCustomer = session()->getId();
        else $idCustomer = Session::get('idCustomer');

        // Lấy ra danh sách sản phẩm mới
        $list_new_pd = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->whereBetween('product.created_at', [$sub30days, now()])->where('StatusPro', '1')->get();

        // Lấy ra danh sách sản phẩm đang sale
        $list_featured_pd = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->leftJoin('saleproduct', 'saleproduct.idProduct', '=', 'product.idProduct')
            ->where('product.StatusPro', '1')
            ->where(function ($query) use ($sub30days) {
                $query->whereBetween('product.created_at', [$sub30days, now()])
                      ->orWhere(function ($query) {
                          $query->where('saleproduct.SaleStart', '<=', now())
                                ->where('saleproduct.SaleEnd', '>=', now());
                      });
            })
            ->select('product.*', 'productimage.*', 'saleproduct.Percent')
            ->orderBy('product.Sold', 'DESC')
            ->get();

        // Lấy ra danh sách sản phẩm bán chạy nhất
        $list_bestsellers_pd = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->where('StatusPro', '1')->orderBy('Sold', 'DESC')->get();

        if (Viewer::where('idCustomer', $idCustomer)->count() == 0) {
            $recommend_pds = $list_bestsellers_pd;
        } else {
            $list_viewed = Viewer::join('product', 'product.idProduct', '=', 'viewer.idProduct')
                ->where('idCustomer', $idCustomer)->select('viewer.idProduct', 'idBrand', 'idCategory', 'ProductName')->orderBy('idView', 'DESC')->get();

            foreach ($list_viewed as $key => $viewed) {
                $idBrand = $viewed->idBrand;
                $idCategory = $viewed->idCategory;

                // Mảng các sản phẩm đã lặp qua
                $checked_pro[] = $viewed->idProduct;

                // Danh sách sản phẩm gợi ý của 1 sản phẩm trong giỏ hàng
                $list_recommend_pds = Product::whereRaw("MATCH (ProductName) AGAINST (?)", Product::fullTextWildcards($viewed->ProductName))
                    ->whereNotIn('idProduct', [$viewed->idProduct])->where('StatusPro', '1')
                    ->select('idProduct');
                $list_recommend_pds->where(function ($list_recommend_pds) use ($idBrand, $idCategory) {
                    $list_recommend_pds->orWhere('idBrand', $idBrand)->orWhere('idCategory', $idCategory);
                });
                $list_recommend_pd = $list_recommend_pds->get();

                if ($list_recommend_pd->count() > 0) {
                    // Thêm từng sản phẩm gợi ý của 1 sản phẩm vào 1 mảng
                    foreach ($list_recommend_pd as $recommend_pd) {
                        $recommend_pds_array[$key][] = $recommend_pd->idProduct;
                    }

                    // Thêm từng mảng thứ $key vào 1 mảng lớn
                    $recommend_pds_arrays[] = $recommend_pds_array[$key];
                }
            }

            if (count($recommend_pds_arrays) > 0) {
                // Hàm gộp mảng, xen kẽ các phần tử của từng mảng
                for ($args = $recommend_pds_arrays; count($args); $args = array_filter($args)) {
                    // &$arg allows array_shift() to change the original.
                    foreach ($args as &$arg) {
                        $output[] = array_shift($arg);
                    }
                }

                $recommend_pds_last = array_diff($output, $checked_pro); // Xóa các sản phẩm đã lặp qua
                $recommend_pds_unique = array_unique($recommend_pds_last); // Lọc các phần tử trùng nhau
                $recommend_pds = json_encode($recommend_pds_unique);
            } else {
                $featured_pds = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
                    ->where('StatusPro', '1')->orderBy('Sold', 'DESC')->select('product.idProduct')->get();

                $featured_pds_array = $featured_pds->pluck('idProduct')->toArray();

                $recommend_pds = json_encode($featured_pds_array);
            }
        }

        return view('shop.home')->with(compact('list_category', 'list_brand', 'list_new_pd', 'list_featured_pd', 'list_bestsellers_pd', 'list_blog', 'recommend_pds'));
    }

    public function getAttributeValueByAttributeId(Request $request)
    {
        $idAttribute = $request->input('attribute_id');

        $attributeValues = AttributeValue::where('idAttribute', $idAttribute)->get();

        $data = [
            'type' => 'success',
            'data' => $attributeValues,
        ];

        return response()->json($data, 200);
    }

    public function getInfo(Request $request)
    {
        $product_id = $request->input('id');
        $value = $request->input('op');

        $product = Product::find($product_id);

        if (!$product ) {
            $data = [
                'type' => 'error',
                'message' => 'Product not found',
            ];
            return response()->json($data, 404);
        }

        $product_option = DB::table('product_attribute')->where('idProduct', $product_id);
        $arr_value = explode(',', $value);

        foreach ($arr_value as $property) {
            $product_option->whereJsonContains('AttrValue', ['property_item' => $property]);
        }

        $product_option = $product_option->first();

        $res = [
            'type' => 'success',
            'data' => $product_option,
        ];
        return response()->json($res, 200);
    }
}
