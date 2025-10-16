<?php

namespace App\Http\Controllers;

use App\Models\AddressCustomer;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttriBute;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Bill;
use App\Models\BillHistory;
use App\Models\BillInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    function array_zip_merge()
    {
        $output = array();
        // The loop incrementer takes each array out of the loop as it gets emptied by array_shift().
        for ($args = func_get_args(); count($args); $args = array_filter($args)) {
            // &$arg allows array_shift() to change the original.
            foreach ($args as &$arg) {
                $output[] = array_shift($arg);
            }
        }
        return $output;
    }

    // Kiểm tra đăng nhập
    public function checkLogin()
    {
        $idCustomer = Session::get('idCustomer');
        if ($idCustomer == false) return Redirect::to('login')->send();
    }

    // Kiểm tra giỏ hàng
    public function checkCart()
    {
        $check_cart = Cart::where('idCustomer', Session::get('idCustomer'))->count();
        if ($check_cart <= 0) Redirect::to('empty-cart')->send();
    }

    // Chuyển đến trang giỏ hàng
    public function show_cart()
    {
        $this->checkLogin();
        $this->checkCart();

        // Kiểm tra trạng thái đăng nhập và trạng thái tài khoản
        if (Session::has('idCustomer')) {
            $idCustomer = Session::get('idCustomer');
            $customer = Customer::find($idCustomer);

            if ($customer && $customer->Status == 0) {
                // Nếu tài khoản bị khóa, hiển thị SweetAlert và chuyển hướng về trang login
                Session::put('idCustomer', null);
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị khóa');
            }
        }

        $list_category = Category::get();
        $list_brand = Brand::get();
        $recommend_pds_arrays = [];
        // join vs product, image và attribute
        // Mỗi sản phẩm trong giỏ hàng đều được lấy thêm dữ liệu sản phẩm (Product) 
        // và thông tin thuộc tính (Attribute, AttributeValue).
        $list_pd_cart = Cart::join('product', 'product.idProduct', '=', 'cart.idProduct')
            ->join('productimage', 'productimage.idProduct', 'cart.idProduct')
            ->join('product_attribute', 'product_attribute.idProAttr', '=', 'cart.proAttr')
            ->where('idCustomer', Session::get('idCustomer'))
            ->cursor()
            ->map(function ($item) {
                $cart = $item->toArray();
                $product = Product::find($item->idProduct);
                $cart['product'] = $product;

                $val = $item->proAttr;
                $product_option = DB::table('product_attribute')->where('idProAttr', $val)->first();
                
                $dataArray = $product_option->AttrValue;
                $dataArray = json_decode($dataArray, true);

                $dataConvert = [];
                foreach ($dataArray as $op) {
                    $attribute = Attribute::find($op['attribute_item']);
                    $property = AttributeValue::find($op['property_item']);

                    $data = [
                        'attribute' => $attribute,
                        'property' => $property
                    ];

                    $dataConvert[] = $data;
                }
                $cart['attribute'] = $dataConvert;
                $cart['product_option'] = $product_option;
                return (object)$cart;
            })->all();

//        $list_pd_cart = $list_pd_cart->transform(function ($pd_cart) {
//            $product = Product::find($pd_cart->idProduct);
//            $pd_cart->product_data = $product;
//
//            $val = $pd_cart->proAttr;
//            $product_option = DB::table('product_attribute')->where('idProAttr', $val)->first();;
//            $dataArray = json_decode($product_option->AttrValue ?? '[]', true);
//
//            $dataConvert = [];
//            foreach ($dataArray as $op) {
//                $attribute = Attribute::find($op['attribute_item']);
//                $property = AttributeValue::find($op['property_item']);
//
//                $dataConvert[] = [
//                    'attribute' => $attribute,
//                    'property' => $property,
//                ];
//            }
//
//            $pd_cart->attribute_data = $dataConvert;
//            $pd_cart->product_option_data = $product_option;
//
//            return $pd_cart;
//        });
        
        // tạo danh sách gợi ý sản phẩm
        foreach ($list_pd_cart as $key => $pd_cart) {
            $idBrand = $pd_cart->idBrand;
            $idCategory = $pd_cart->idCategory;

            //Mảng các sản phẩm đã lặp qua
            $checked_pro[] = $pd_cart->idProduct;

            // Danh sách sản phẩm gợi ý của 1 sản phẩm trong giỏ hàng( tìm theo tên gần giống, thương hiệu/ danh mục)
            $list_recommend_pds = Product::whereRaw("MATCH (ProductName) AGAINST (?)", Product::fullTextWildcards($pd_cart->ProductName))
                ->whereNotIn('idProduct', [$pd_cart->idProduct])->where('StatusPro', '1')
                ->select('idProduct');
            // Tạo mảng đa chiều chứa danh sách gợi ý cho từng sản phẩm
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
        // nếu có gơi ý
        if (count($recommend_pds_arrays) > 0) {
            // Hàm gộp mảng, xen kẽ các phần tử của từng mảng
            //Gộp tất cả mảng con ($recommend_pds_arrays) thành 1 mảng duy nhất ($output), theo kiểu đan xen từng phần tử.
            for ($args = $recommend_pds_arrays; count($args); $args = array_filter($args)) {
                // &$arg allows array_shift() to change the original.
                foreach ($args as &$arg) {
                    $output[] = array_shift($arg);
                }
            }

            $recommend_pds_last = array_diff($output, $checked_pro); // Xóa các sản phẩm đã lặp qua
            $recommend_pds_unique = array_unique($recommend_pds_last); // Lọc các phần tử trùng nhau
            $recommend_pds = json_encode($recommend_pds_unique);// encode json để truyền sang view
        } else { // nếu k có gợi ý. dùng sản phẩm bán chạy (orderBy('Sold'))
            $featured_pds = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
                ->where('StatusPro', '1')->orderBy('Sold', 'DESC')->select('product.idProduct')->get();

            $featured_pds_array = $featured_pds->pluck('idProduct')->toArray();

            $recommend_pds = json_encode($featured_pds_array);
        }

        return view("shop.cart.cart")->with(compact('list_category', 'list_brand', 'list_pd_cart', 'recommend_pds'));
    }

    // Gợi ý sản phẩm trang giỏ hàng
    public static function get_product($idProduct)
    {
        return Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->where('product.idProduct', $idProduct)->select('ImageName', 'product.*')->first();
    }

    // Chuyển đến trang thanh toán
    public function payment()
    {
        $this->checkLogin();
        $this->checkCart();

        // Kiểm tra trạng thái đăng nhập và trạng thái tài khoản
        if (Session::has('idCustomer')) {
            $idCustomer = Session::get('idCustomer');
            $customer = Customer::find($idCustomer);

            if ($customer && $customer->Status == 0) {
                // Nếu tài khoản bị khóa, hiển thị SweetAlert và chuyển hướng về trang login
                Session::put('idCustomer', null);
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị khóa');
            }
        }

        $list_category = Category::get();
        $list_brand = Brand::get();
        $customer = Customer::find(Session::get('idCustomer'));

        // Mỗi sản phẩm trong giỏ hàng đều được lấy thêm dữ liệu sản phẩm (Product) 
        // và thông tin thuộc tính (Attribute, AttributeValue).
        $list_pd_cart = Cart::join('product', 'product.idProduct', '=', 'cart.idProduct')
            ->join('productimage', 'productimage.idProduct', 'cart.idProduct')
            ->join('product_attribute', 'product_attribute.idProAttr', '=', 'cart.proAttr')
            ->where('idCustomer', Session::get('idCustomer'))
            ->cursor()
            ->map(function ($item) {
                $cart = $item->toArray();
                $product = Product::find($item->idProduct);
                $cart['product'] = $product;

                $val = $item->proAttr;
                $product_option = DB::table('product_attribute')->where('idProAttr', $val)->first();
                $dataArray = $product_option->AttrValue;
                $dataArray = json_decode($dataArray, true);

                $dataConvert = [];
                foreach ($dataArray as $op) {
                    $attribute = Attribute::find($op['attribute_item']);
                    $property = AttributeValue::find($op['property_item']);

                    $data = [
                        'attribute' => $attribute,
                        'property' => $property
                    ];

                    $dataConvert[] = $data;
                }
                $cart['attribute'] = $dataConvert;
                $cart['product_option'] = $product_option;
                return (object)$cart;
            })->all();


        return view("shop.cart.payment")->with(compact('list_category', 'list_brand', 'customer', 'list_pd_cart'));
    }

    // Chuyển đến trang giỏ hàng trống
    public function empty_cart()
    {
        $list_category = Category::get();
        $list_brand = Brand::get();
        return view("shop.cart.empty-cart")->with(compact('list_category', 'list_brand'));
    }

    // Chuyển đến trang đặt hàng thành công
    public function success_order(Request $request)
    {
        $list_category = Category::get();
        $list_brand = Brand::get();
        $url = $request->fullUrl();

        //Thanh toán VNPay
        if ($request->vnp_TransactionStatus && $request->vnp_TransactionStatus == '00') {
            // khởi tạo model
            $Bill = new Bill(); 
            $BillHistory = new BillHistory();

            //Tách vnp_OrderInfo để lấy thông tin cần thiết:
            $OrderInfo = explode("_", $request->vnp_OrderInfo);

            $idCustomer = $OrderInfo[2];
            $Voucher = $OrderInfo[1];
            $idVoucher = $OrderInfo[3];
            // Lấy địa chỉ người nhận (tùy theo có dùng địa chỉ mặc định hay không):
            if ($OrderInfo[0] == 'default') {
                $customer = Customer::find($idCustomer);
                $Bill->Address = $customer->Address;
                $Bill->PhoneNumber = $customer->PhoneNumber;
                $Bill->CustomerName = $customer->CustomerName;
            } else {
                $get_address = AddressCustomer::find($OrderInfo[0]);
                $Bill->Address = $get_address->Address;
                $Bill->PhoneNumber = $get_address->PhoneNumber;
                $Bill->CustomerName = $get_address->CustomerName;
            }
            // Tạo mới bản ghi, lưu thông tin ng nhận,tổng tiền, trạng thái, hình thức
            $Bill->idCustomer = $idCustomer;
            $Bill->TotalBill = $request->vnp_Amount / 100;
            $Bill->Voucher = $Voucher;
            $Bill->Status = 1;
            $Bill->Payment = 'vnpay';
            $Bill->save();
            // lấy đơn vừa tạo và danh sách giỏ hàng của khách hàng
            $get_Bill = Bill::where('created_at', now())->where('idCustomer', $idCustomer)->first();
            $get_cart = Cart::where('idCustomer', $idCustomer)->get();
            // ghi vào billinfo
            foreach ($get_cart as $key => $cart) {
                $data_billinfo = array(
                    'idBill' => $get_Bill->idBill,
                    'idProduct' => $cart->idProduct,
                    'AttributeProduct' => $cart->AttributeProduct,
                    'Price' => $cart->PriceNew,
                    'QuantityBuy' => $cart->QuantityBuy,
                    'idProAttr' => $cart->proAttr,
                    'proAttr' => $cart->proAttr,
                    'created_at' => now(),
                    'updated_at' => now()
                );

                /* Lấy id của đơn hàng để kiểm tra và giảm trừ số lượng */
                BillInfo::insert($data_billinfo);
                DB::update(DB::RAW('update product set QuantityTotal = QuantityTotal - ' . $cart->QuantityBuy . ' where idProduct = ' . $cart->idProduct));
                DB::update(DB::RAW('update product_attribute set Quantity = Quantity - ' . $cart->QuantityBuy . ' where idProAttr = ' . $cart->proAttr));
            }
            // cập nhật số lượng voucher, nếu có
            if ($get_Bill->Voucher != '') {
                DB::update(DB::RAW('update voucher set VoucherQuantity = VoucherQuantity - 1 where idVoucher = ' . $idVoucher));
            }
            Cart::where('idCustomer', $idCustomer)->delete(); // xóa giỏ hàng
            $BillHistory->idBill = $get_Bill->idBill;
            $BillHistory->AdminName = 'System';
            $BillHistory->Status = 1;
            $BillHistory->save();
            return view("shop.cart.success-order")->with(compact('list_category', 'list_brand'));
        } else if ($request->vnp_TransactionStatus && $request->vnp_TransactionStatus != '00') {
            return Redirect::to('cart');
        }
    }

    // Hiện giỏ hàng ở header
    public static function get_cart_header()
    {   
        // lấy tổng số lượng sản phẩm có trong giỏ hàng
        $sum_cart = Cart::where('idCustomer', Session::get('idCustomer'))->sum('QuantityBuy');
        //Join các bảng liên quan để lấy được thông tin chi tiết sản phẩm (tên, ảnh, thuộc tính...).
        $get_cart_header = Cart::join('product', 'product.idProduct', '=', 'cart.idProduct')
            ->join('productimage', 'productimage.idProduct', 'cart.idProduct')
            ->join('product_attribute', 'product_attribute.idProAttr', '=', 'cart.proAttr')
            ->where('idCustomer', Session::get('idCustomer'))
            ->cursor()
            ->map(function ($item) {
                //Lấy sản phẩm gốc từ bảng product để gắn vào mỗi dòng $cart.
                $cart = $item->toArray();
                $product = Product::find($item->idProduct);
                $cart['product'] = $product;

                $val = $item->proAttr;
                $product_option = DB::table('product_attribute')->where('idProAttr', $val)->first();
                $dataArray = $product_option->AttrValue;
                $dataArray = json_decode($dataArray, true);

                $dataConvert = [];
                foreach ($dataArray as $op) {//Tìm tên thuộc tính (ví dụ: Màu, Size) và giá trị tương ứng (Đỏ, 35)
                    $attribute = Attribute::find($op['attribute_item']);
                    $property = AttributeValue::find($op['property_item']);

                    $data = [
                        'attribute' => $attribute,
                        'property' => $property
                    ];

                    $dataConvert[] = $data;
                }//Gắn thêm thuộc tính vào mỗi dòng giỏ hàng, rồi trả về dạng object để dễ xử lý trong view.
                $cart['attribute'] = $dataConvert;
                $cart['product_option'] = $product_option;
                return (object)$cart;
            })->all();
        //sum_cart: tổng số lượng để hiện số nhỏ bên biểu tượng
        //get_cart_header: danh sách sản phẩm chi tiết để show hình ảnh, tên, thuộc tính...
        return ['sum_cart' => $sum_cart, 'get_cart_header' => $get_cart_header];
    }

    // Mua ngay
    public function buy_now(Request $request)
    {
        $this->checkLogin();

        // Kiểm tra trạng thái đăng nhập và trạng thái tài khoản
        if (Session::has('idCustomer')) {
            $idCustomer = Session::get('idCustomer');
            $customer = Customer::find($idCustomer);

            if ($customer && $customer->Status == 0) {
                // Nếu tài khoản bị khóa, hiển thị SweetAlert và chuyển hướng về trang login
                Session::put('idCustomer', null);
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị khóa');
            }
        }

        $data = $request->all();    // lấy dữ liệu từ form
        $cart = new Cart(); // tạo bảng mới
        // Gán thông tin giỏ hàng
        $cart->idProduct = $data['idProduct'];
        $cart->QuantityBuy = $data['qty_buy'];
        $cart->PriceNew = $data['PriceNew'];
        $cart->Total = $data['PriceNew'] * $data['qty_buy'];
        $cart->idCustomer = Session::get('idCustomer');
        $cart->AttributeProduct = $data['AttributeProduct'];
        $cart->proAttr = $data['proAttr'];
        $qty_of_attr = $data['qty_of_attr'];

        // kiểm tra sản phẩm có trong giỏ chưa
        // Nếu sản phẩm với thuộc tính (proAttr) đã có, thì cộng dồn số lượng thay vì thêm dòng mới.
        $find_pd = Cart::where('idProduct', $data['idProduct'])->where('idCustomer', Session::get('idCustomer'))
            ->where('proAttr', $data['proAttr'])->first();

        // kiểm tra tồn kho
        if ($find_pd) {
            $QuantityBuy = $data['qty_buy'] + $find_pd->QuantityBuy;
            if ($QuantityBuy > $qty_of_attr) {  //Nếu vượt quá số lượng còn lại (qty_of_attr), thông báo lỗi.
                return redirect()->back()->with('error', 'Vượt quá số lượng sản phẩm hiện có!');
            } else {    //Nếu không, cập nhật lại số lượng và tổng tiền trong giỏ.
                $Total = $QuantityBuy * $data['PriceNew'];

                Cart::where('idProduct', $data['idProduct'])->where('idCustomer', Session::get('idCustomer'))
                    ->where('proAttr', $data['proAttr'])->update(['QuantityBuy' => $QuantityBuy, 'Total' => $Total]);

                return Redirect::to('cart')->send();
            }
        } else {    // nếu chưa có
            $cart->save();  //Thêm sản phẩm mới vào giỏ và chuyển đến trang giỏ hàng.
            return Redirect::to('cart')->send();
        }
    }

    // Thêm vào giỏ hàng
    public function add_to_cart(Request $request)
    {
        $this->checkLogin();

        $data = $request->all();
        $cart = new Cart();
        // gán dữ liệu vào model
        $cart->idProduct = $data['idProduct'];
        $cart->QuantityBuy = $data['QuantityBuy'];
        $cart->PriceNew = $data['PriceNew'];
        $cart->Total = $data['PriceNew'] * $data['QuantityBuy'];
        $cart->idCustomer = Session::get('idCustomer');
        $cart->AttributeProduct = $data['AttributeProduct'];
        $cart->proAttr = $data['proAttr'];
        $qty_of_attr = $data['qty_of_attr'];
        // thông báo thêm thành công
        $output = '<div class="modal fade modal-AddToCart" id="successAddToCart" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="exampleModalCenterTitle">Thông báo</h5></div>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true"></span></button>
            <div class="modal-body text-center p-3 h4"><div class="mb-3">
            <i class="fa fa-check-circle text-primary" style="font-size:50px;"></i></div>Đã thêm sản phẩm vào giỏ hàng</div>
            <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" id="continue-shopping" data-dismiss="modal">Tiếp tục mua sắm</button>
            <a href="../cart" type="button" class="btn btn-primary">Đi đến giỏ hàng</a></div></div></div></div>';
        // kiểm tra sản phẩm có trong giỏ chưa ?
        $find_pd = Cart::where('idProduct', $data['idProduct'])->where('idCustomer', Session::get('idCustomer'))
            ->where('proAttr', $data['proAttr'])->first();
        // kiểm tra tồn kho
        if ($find_pd) { // nếu vượt quá số lượng trả thống báo lỗi
            $QuantityBuy = $data['QuantityBuy'] + $find_pd->QuantityBuy;
            if ($QuantityBuy > $qty_of_attr) {
                $output = '<div id="errorAddToCart" class="modal fade bd-example-modal-sm modal-AddToCart" tabindex="-1" role="dialog"  aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Thông báo</h5></div><button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button><div class="modal-body"><p>Vượt quá số lượng sản phẩm hiện có!</p></div><div class="modal-footer justify-content-center"><button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button></div></div></div></div>';
                echo $output;
            } else {    // ngược lại, cập nhật số lượng và tổng tiền sản phẩm đó
                $Total = $QuantityBuy * $data['PriceNew'];

                Cart::where('idProduct', $data['idProduct'])->where('idCustomer', Session::get('idCustomer'))
                    ->where('proAttr', $data['proAttr'])->update(['QuantityBuy' => $QuantityBuy, 'Total' => $Total]);

                echo $output;
            }
        } else {    // nếu chưa có trong giỏ
            $cart->save();
            echo $output;   // lưu bản ghi mới vào bảng và trả modal thành công
        }
    }

    // Xóa 1 sản phẩm trong giỏ hàng
    public function delete_pd_cart($idCart)
    {
        Cart::destroy($idCart);//Sử dụng destroy() xóa dòng trong bảng cart theo khóa chính (idCart).

        // Kiểm tra giỏ hàng sau khi xóa
        $check_cart = Cart::where('idCustomer', Session::get('idCustomer'))->count();

        return response()->json(['success' => true, 'empty' => $check_cart <= 0]);
    }

    // Xóa toàn bộ giỏ hàng
    public function delete_cart()
    {
        Cart::truncate(); // xóa toàn bộ bảng
        return Redirect::to('empty-cart')->send();
    }

    // Cập nhật số lượng mua trong giỏ hàng
    public function update_qty_cart(Request $request)
    {   
        
        $this->checkCart();// kiểm tra giỏ hàng
        $data = $request->all();    // lấy dữ liệu request
        //Kiểm tra nếu số lượng người dùng chọn > số lượng tồn kho:
        if ($data['QuantityBuy'] > $data['Quantity']) {
            Cart::where('idCart', $data['idCart'])
                ->update(array('QuantityBuy' => $data['Quantity'], 'Total' => $data['PriceNew'] * $data['Quantity']));
        } else {   //Ngược lại: số lượng người dùng chọn hợp lệ
            Cart::where('idCart', $data['idCart'])
                ->update(array('QuantityBuy' => $data['QuantityBuy'], 'Total' => $data['PriceNew'] * $data['QuantityBuy']));
        }
    }

    // Hiện danh sách voucher còn HSD trong ô input
    public function getVouchers(Request $request)
    {   
        //Lấy thông tin khách hàng từ session
        $idCustomer = Session::get('idCustomer');
        $hasBought = Bill::where('idCustomer', $idCustomer)->exists();

        //Lọc các voucher còn hạn sử dụng (VoucherEnd lớn hơn hoặc bằng thời gian hiện tại).
        $vouchers = Voucher::where('VoucherEnd', '>=', now())

        //Nếu là khách hàng đã từng mua, thì không cho hiển thị mã giảm giá CHAOMUNG (chỉ dành cho khách mới).
            ->when($hasBought, function ($query) {
                return $query->where('VoucherCode', '!=', 'CHAOMUNG');
            })
            //Lấy danh sách mã giảm giá, chỉ cần trường VoucherCode, sắp xếp theo thứ tự idVoucher.
            ->orderBy('idVoucher', 'asc')
            ->get(['VoucherCode']);

        return response()->json($vouchers);
    }

    // Áp dụng mã giảm giá
    public function check_voucher(Request $request)
    {

        // subtotal: Tổng tiền hàng (Chưa tính tiền ship)
        // TotalBill: Thành tiền (Đã tính tiền ship)

        $data = $request->all();    
        $voucherCode = $data['VoucherCode'];

        $subtotal = $data['subtotal'];  // tổng tiền hàng
        $ship = $data['ship'];  // phí vận chuyển

        // Lấy thông tin khách hàng từ session
        $idCustomer = Session::get('idCustomer');
        $hasBought = Bill::where('idCustomer', $idCustomer)->exists();

        // Kiểm tra mã CHAOMUNG với khách đã mua hàng
        if ($voucherCode == 'CHAOMUNG' && $hasBought) {
            return response()->json('Voucher chỉ dành cho đơn mua hàng đầu tiên');
        }

        // Kiểm tra điều kiện mã "freeship" áp dụng cho các đơn từ 1tr trở xuống
        if ($voucherCode == 'freeship') {
            if ($subtotal >= 1000000) {
                return response()->json('Mã "freeship" chỉ áp dụng cho đơn hàng dưới 1.000.000đ');
            } else {
                if ($ship > 0 && $ship == 30000) {
                    // Nếu phí vận chuyển là 30k, áp dụng mã freeship để giảm 30k
                    $output = 'Success-0-30000-0'; // Success-[Số tiền được giảm]-[Phí ship trước khi áp dụng mã]-[Mã khác nếu có]
                    return response()->json($output);
                } else {
                    // Nếu phí vận chuyển đã miễn phí, không thể áp dụng mã freeship
                    return response()->json('Đơn hàng đã được miễn phí vận chuyển, không thể áp dụng mã "freeship"');
                }
            }
        }

        // Kiểm tra điều kiện mã "GIAMGIA100K" áp dụng cho các đơn từ 700k trở lên
        // if ($voucherCode == 'GIAMGIA100K') {
        //     if ($subtotal < 700000) {
        //         return response()->json('Mã "GIAMGIA100K" chỉ áp dụng cho đơn hàng có tổng giá trị từ 700,000đ trở lên');
        //     } else {
        //         $output = 'Success-0-100000-0';
        //         return response()->json($output);
        //     }
        // }

        // dùng BINARY phân biệt chữ hoa hay THƯỜNG
        $check_voucher = Voucher::whereRaw('BINARY `VoucherCode` = ?', [$voucherCode])->first();
        // kiểm tra mã giảm giá
        if ($check_voucher) {
            if ($check_voucher->VoucherEnd < now()) {   // Hết hạn
                return response()->json('Mã giảm giá này đã hết hạn');
            } else if ($check_voucher->VoucherStart > now()) {  // chưa đến ngày bắt đầu
                return response()->json('Chưa đến thời gian áp dụng mã giảm giá này');
            } else if ($check_voucher->VoucherQuantity <= 0) {  // hết lượt
                return response()->json('Mã giảm giá này đã hết số lần sử dụng');
            } else {    // thỏa mãn điều kiện, trả kq Success
                $output = 'Success-' . $check_voucher->VoucherCondition . '-' . $check_voucher->VoucherNumber . '-' . $check_voucher->idVoucher;
                return response()->json($output);
            }
        } else {    // nếu k tìm thấy mã
            return response()->json('Mã giảm giá không hợp lệ');
        }
    }

    // Đặt hàng
    public function submit_payment(Request $request)
    {
        $data = $request->all();

        // Kiểm tra trạng thái đăng nhập và trạng thái tài khoản
        if (Session::has('idCustomer')) {
            $idCustomer = Session::get('idCustomer');
            $customer = Customer::find($idCustomer);

            if ($customer && $customer->Status == 0) {
                // Nếu tài khoản bị khóa, hiển thị SweetAlert và chuyển hướng về trang login
                Session::put('idCustomer', null);
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị khóa');
            }
        } else {
            return redirect('/login')->with('message', 'Vui lòng đăng nhập trước khi thanh toán');
        }
        // khởi tạo dữ liệu
        $list_category = Category::get();
        $list_brand = Brand::get();
        $Bill = new Bill();
        $idCustomer = Session::get('idCustomer');
        // thanh toán bằng VNPAY
        if ($data['checkout'] == 'vnpay') {
            //TẠO DỮ LIỆU GỬI LÊN VNPAY
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";   // Địa chỉ gọi API
            $vnp_Returnurl = "http://localhost/kidolshop/success-order";//URL mà VNPAY redirect về sau khi thanh toán xong.
            $vnp_TmnCode = "135HNKES";//Mã website tại VNPAY
            $vnp_HashSecret = "PNTYSDLJBKCKUTQCWFPRRBPJLBECSWCR"; //Chuỗi bí mật

            //CHUẨN BỊ THÔNG TIN GỬI ĐẾN VNPAY
            $vnp_TxnRef = base64_encode(openssl_random_pseudo_bytes(30)); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $data['address_rdo'] . '_' . $data['Voucher'] . '_' . Session::get('idCustomer') . '_' . $data['idVoucher'];// nội dung ghi chú cho giao dịch
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $data['TotalBill'] * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $_POST['txtexpire'];
            //Billing
            //TẠO CHUỖI PARAMETER VÀ CHỮ KÝ
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            //TẠO CHỮ KÝ (SECURE HASH)
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                //TẠO LINK THANH TOÁN & REDIRECT
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            //TRẢ VỀ KẾT QUẢ
            $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
        // THANH TOÁN TIỀN MẶT
        } else if ($data['checkout'] == 'cash') {
            // điền thông tin địa chỉ, chọn địa chỉ mặc dịnh hoặc địa chỉ đã lưu
            if ($data['address_rdo'] == 'default') {
                $customer = Customer::find($idCustomer);
                $Bill->Address = $customer->Address;
                $Bill->PhoneNumber = $customer->PhoneNumber;
                $Bill->CustomerName = $customer->CustomerName;
            } else {
                $get_address = AddressCustomer::find($data['address_rdo']);
                $Bill->Address = $get_address->Address;
                $Bill->PhoneNumber = $get_address->PhoneNumber;
                $Bill->CustomerName = $get_address->CustomerName;
            }
            // lưu thông tin hóa đơn
            $Bill->idCustomer = $idCustomer;
            $Bill->TotalBill = $data['TotalBill'];
            $Bill->Voucher = $data['Voucher'];
            $Bill->Payment = 'cash';
            $Bill->save();
            // xử lý đơn hàng
            $get_Bill = Bill::where('created_at', now())->where('idCustomer', $idCustomer)->first();
            $get_cart = Cart::where('idCustomer', $idCustomer)->get();
            // Chèn dữ liệu vào bảng billinfo
            foreach ($get_cart as $key => $cart) {
                $data_billinfo = array(
                    'idBill' => $get_Bill->idBill,
                    'idProduct' => $cart->idProduct,
                    'AttributeProduct' => $cart->AttributeProduct,
                    'Price' => $cart->PriceNew,
                    'QuantityBuy' => $cart->QuantityBuy,
                    'idProAttr' => $cart->idProAttr,
                    'proAttr' => $cart->proAttr,
                    'created_at' => now(),
                    'updated_at' => now()
                );
                BillInfo::insert($data_billinfo);
                //Trừ số lượng tồn kho
                DB::update(DB::RAW('update product set QuantityTotal = QuantityTotal - ' . $cart->QuantityBuy . ' where idProduct = ' . $cart->idProduct));
                DB::update(DB::RAW('update product_attribute set Quantity = Quantity - ' . $cart->QuantityBuy . ' where idProAttr = ' . $cart->proAttr));
            }
            // Trừ số lượng voucher nếu có sử dụng
            if ($get_Bill->Voucher != '') {
                DB::update(DB::RAW('update voucher set VoucherQuantity = VoucherQuantity - 1 where idVoucher = ' . $data['idVoucher']));
            }
            // xóa giỏ hàng và chuyển đến trang thành công
            Cart::where('idCustomer', $idCustomer)->delete();
            return view("shop.cart.success-order")->with(compact('list_category', 'list_brand'));
        } else if ($data['checkout'] == 'momo') {
            // Momo payment code
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMO';
            $accessKey = 'F8BBA842ECF85';
            $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
            $orderId = time() . "";
            $orderInfo = $data['address_rdo'] . '_' . $data['Voucher'] . '_' . Session::get('idCustomer') . '_' . $data['idVoucher'];
            $amount = $data['TotalBill'];
            $redirectUrl = "http://localhost/kidolshop/success-order";
            $ipnUrl = "http://localhost/kidolshop/ipn";
            $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";
            $extraData = ($extraData ? $extraData : "");

            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            $result = $this->execPostRequest($endpoint, json_encode($data));
            $momoResponse = json_decode($result, true);

            if (isset($momoResponse['payUrl'])) {
                return Redirect::to($momoResponse['payUrl'])->send();
            } else {
                return Redirect::to('cart')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
            }
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // execute post
        $result = curl_exec($ch);
        // close connection
        curl_close($ch);
        return $result;
    }
}
