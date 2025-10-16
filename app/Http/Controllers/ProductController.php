<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SaleProduct;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttriBute;
use App\Models\Voucher;
use App\Models\WishList;
use App\Models\Viewer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PDO;

class ProductController extends Controller
{
    /* ---------- Admin ---------- */

    // Chuyển đến trang quản lý sản phẩm
    public function manage_products()
    {   // lấy danh sách sản phẩm kèm thông tin của thương hiệu- danh mục- hình ảnh
        $list_product = Product::join('brand', 'brand.idBrand', '=', 'product.idBrand')
            ->join('category', 'category.idCategory', '=', 'product.idCategory')
            ->join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->orderBy('product.idProduct', 'asc')// sắp xếp thứ tự tăng dần
            ->paginate(10); //chia danh sách thành nhiều trang, mỗi trang 10 sản phẩm
        $count_product = Product::count();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.manage-products")->with(compact('list_product', 'count_product', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang thêm sản phẩm
    public function add_product()
    {
        $list_category = Category::get();// lấy danh sách danh mục
        $list_brand = Brand::get(); // lấy danh sách thương hiệu
        $list_attribute = Attribute::get(); //lấy danh sách thuộc tính

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.add-product")->with(compact('list_category', 'list_brand', 'list_attribute', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang sửa sản phẩm
    public function edit_product($idProduct)
    {
        $product = Product::join('brand', 'brand.idBrand', '=', 'product.idBrand') // lấy thông tin sản phẩm
            ->join('category', 'category.idCategory', '=', 'product.idCategory')
            ->join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->where('product.idProduct', $idProduct)->first();
        // lấy ra danh sách thuộc tính cụ thể đã gán trong sp. phục vụ hiển thị bảng thuộc tính trong giao diện
        $list_pd_attr = ProductAttriBute::join('attribute_value', 'attribute_value.idAttrValue', '=', 'product_attribute.idAttrValue')
            ->join('attribute', 'attribute.idAttribute', '=', 'attribute_value.idAttribute')
            ->where('product_attribute.idProduct', $idProduct)->get();

        $name_attribute = ProductAttriBute::join('attribute_value', 'attribute_value.idAttrValue', '=', 'product_attribute.idAttrValue')
            ->join('attribute', 'attribute.idAttribute', '=', 'attribute_value.idAttribute')
            ->where('product_attribute.idProduct', $idProduct)->first();//Lấy thuộc tính đầu tiên để xác định xem 
            // sản phẩm có nhóm thuộc tính nào (ví dụ: thuộc về Size hay Color)

        $list_attribute = Attribute::get();//lấy toàn bộ danh sách để hiển thị
        $list_category = Category::get();
        $list_brand = Brand::get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        //Chuyển Eloquent object thành mảng PHP thuần để xử lý dễ hơn.
        $productArray = $product->toArray();
        //option chọn trong thuộc tính
        $product_option = ProductAttriBute::where('idProduct', $idProduct)//lấy từng dòng attibute liên quan sản phẩm và xử lý
            ->cursor()      // từng cái một bằng cursor và map để tiết kiệm bộ nhớ
            ->map(function ($item) {
                $option_item = $item->toArray();    //biến từng ProductAttriBute thành mảng để dễ thao tác
                //Biến AttrValue từ JSON string thành mảng (ví dụ: [{"attribute_item":1,"property_item":3}, ...])
                $options = $item->AttrValue;
                $options = json_decode($options, true);
                //Tạo một mảng rỗng $data để chứa tất cả các cặp thuộc tính và giá trị.
                $data = [];
                foreach ($options as $key => $option) {
                    $ite = [];
        //Lấy tên thuộc tính và giá trị tương ứng từ ID trong JSON.Ví dụ: attribute_item = 1 → "Size", property_item = 3 → "35".
                    $attribute = Attribute::find($option['attribute_item']);
                    $property = AttributeValue::find($option['property_item']);
                    //Lưu cả 2 đối tượng vào $ite, để sau này hiển thị tên thuộc tính và giá trị trong form.
                    $ite['attribute_item'] = $attribute;
                    $ite['property_item'] = $property;

                    $data[] = $ite; //Đưa từng cặp attribute + value vào mảng $data.
                }
                //Thêm options đã xử lý vào mỗi dòng của product_attribute, rồi trả về kết quả hoàn chỉnh.
                $option_item['options'] = $data;
                return $option_item;
            });
        //Gắn phần options vừa xử lý vào productArray để mang sang view hiển thị.
        $productArray['options'] = $product_option;
        // truyền toàn bộ dữ liệu sang view
        return view("admin.product.edit-product")->with(compact('product', 'productArray', 'list_category', 'list_brand', 'list_attribute', 'list_pd_attr', 'name_attribute', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang quản lý khuyến mãi
    public function manage_sale()
    {   // lấy danh sách sản phẩm khuyễn mãi
        $list_sale = SaleProduct::join('product', 'product.idProduct', '=', 'saleproduct.idProduct')
            ->join('productimage', 'productimage.idProduct', '=', 'product.idProduct')->get();

        $count_sale = SaleProduct::count();// đếm số lượng sản phẩm khuyến mãi

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.sale.manage-sale")->with(compact('list_sale', 'count_sale', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang thêm khuyến mãi
    public function add_sale()
    {   // lấy danh sách sản phẩm chưa có khuyến mãi
        $list_product = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->leftJoin('saleproduct', 'product.idProduct', '=', 'saleproduct.idProduct')
            ->whereNull('saleproduct.idProduct')
            ->select('product.*', 'productimage.ImageName')
            ->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.sale.add-sale")->with(compact('list_product', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang sửa khuyến mãi
    public function edit_sale($idSale, $idProduct)
    {   //lấy thông tin chưa tiết sản phẩm đang khuyến mãi. SaleProduct: là bảng lưu các thông tin khuyến mãi sản phẩm.
        $sale_product = SaleProduct::join('product', 'product.idProduct', '=', 'saleproduct.idProduct')
            ->join('productimage', 'productimage.idProduct', '=', 'product.idProduct')->where('idSale', $idSale)->first();
        //idsale: lọc đúng bản ghi khuyến mãi cần sửa (theo ID khuyến mãi).first():chỉ lấy một bản ghi đầu tiên (vì ID là duy nhất).
        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.sale.edit-sale")->with(compact('sale_product', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang quản lý mã giảm giá
    public function manage_voucher()
    {
        $list_voucher = Voucher::whereNotIn('idVoucher', [0])->get();//lấy danh sách mã giảm giá trừ id=0, lưu vào biến list_vc
        $count_voucher = Voucher::whereNotIn('idVoucher', [0])->count();//đếm tổng số lượng mã giảm giá

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.voucher.manage-voucher")->with(compact('list_voucher', 'count_voucher', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang thêm mã giảm giá
    public function add_voucher()
    {
        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.voucher.add-voucher")->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang sửa mã giảm giá
    public function edit_voucher($idVoucher)
    {
        $voucher = Voucher::find($idVoucher);// tìm mã giảm theo id

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.product.voucher.edit-voucher")->with(compact('voucher', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Thêm sản phẩm
    public function submit_add_product(Request $request)
    {
        $data = $request->all();//lấy dữ liệu nhập vào từ request(tên,mô tả,giá,thuộc tính,v..v)
        //Kiểm tra trong DB có sản phẩm nào có ProductSlug trùng với slug mới nhập không.
        $select_product = Product::where('ProductSlug', $data['ProductSlug'])->first();

        if ($select_product) {
            return redirect()->back()->with('error', 'Sản phẩm này đã tồn tại');
        } else {    //nếu không trùng
            $product = new Product();   // tạo mới product
            $product_image = new ProductImage();    //tạo mới hình ảnh
            // gán dữ liệu từ form vào model Product
            $product->ProductName = $data['ProductName'];
            $product->idCategory = $data['idCategory'];
            $product->idBrand = $data['idBrand'];
            $product->Price = $data['Price'];
            $product->QuantityTotal = 0;
            $product->ShortDes = $data['ShortDes'];
            $product->DesProduct = $data['DesProduct'];
            $product->ProductSlug = $data['ProductSlug'];
            $get_image = $request->file('ImageName');
            $timestamp = now();
            // lưu sản phẩm vào dtb
            $product->save();
            //Sau khi lưu, dùng created_at để lấy lại đúng sản phẩm vừa lưu (do $product->idProduct chưa có ở trên).
            $get_pd = Product::where('created_at', $timestamp)->first();
    
            // Lưu giá trị thuộc tính sản phẩm
            $data_options = $request->input('data_options');    // lấy dữ liệu thuộc tính từ form
            //Dữ liệu thuộc tính là mảng JSON gồm các tổ hợp thuộc tính (VD: màu đỏ + size 34, size 35...),được giải mã sang mảng PHP.
            $data_options = json_decode($data_options, true);

            //Duyệt từng biến thể để lưu vào bảng product_attribute
            //Mỗi biến thể gồm: _options: thông tin thuộc tính (VD: size M + màu đỏ),quantity: số lượng tương ứng
            $product_qty = $product->QuantityTotal; // lấy tổng số lượng hiện tại của sản phẩm
            foreach ($data_options as $data_option) { // duyệt qua từng mảng biến thể
                $data_values = json_encode($data_option['_options'], JSON_THROW_ON_ERROR);//Chuyển mảng thuộc tính thành chuỗi JSON để lưu vào DB.
                //vd: ['_options'] => ['color' => 'red', 'size' => '35'] sẽ thành: {"color":"red","size":"35"}
                
                //Tìm xem biến thể sản phẩm này (dựa vào idProduct + AttrValue) đã có trong bảng productattribute chưa.
                $product_option = ProductAttriBute::where('idProduct', $get_pd->idProduct)->where('AttrValue', $data_values)->first();

                $quantity = $data_option['quantity'];  // lấy số lượng nhập cho biến thể
                //Nếu biến thể đã tồn tại, thì cộng thêm số lượng mới vào số cũ.
                if ($product_option) {
                    $product_option->Quantity = (integer)$product_option->Quantity + (integer)$quantity;
                } else { // ngược lại tạo mới bản ghi và gán số lượng
                    $product_option = new ProductAttriBute();
                    $product_option->Quantity = $quantity;
                }
                //Lấy idProduct từ sản phẩm vừa tạo để gán vào bản ghi mới.
                $product_id = $get_pd->idProduct;
                //Gán idProduct cho biến thể.
                $product_option->idProduct = $product_id;
                //Gán giá trị thuộc tính (màu + size ở dạng JSON) cho bản ghi.
                $product_option->AttrValue = $data_values;
                //Lưu biến thể vào bảng productattribute.
                $product_option->save();
                //Cộng dồn số lượng từ từng biến thể để cập nhật lại QuantityTotal sau cùng cho sản phẩm.
                $product_qty += $quantity;
            }

            // Thêm hình ảnh vào table ProductImage
            foreach ($get_image as $image) {
                $get_name_image = $image->getClientOriginalName();  // lấy tên gốc file ảnh
                //Lấy phần tên không bao gồm đuôi mở rộng (VD: từ ao_mau_do.jpg thành ao_mau_do).
                $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
                $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();//tạo tên ảnh mới tránh trùng lặp
                $image->storeAs('public/kidoldash/images/product', $new_image); // lưu vào thư mục
                //Thêm tên ảnh mới vào mảng $images để sau đó lưu lại toàn bộ danh sách ảnh vào bảng ProductImage.
                $images[] = $new_image;
            }
            //Chuyển mảng tên ảnh ($images) thành chuỗi JSON để lưu vào DB (vì 1 sản phẩm có nhiều ảnh).
            $product_image->ImageName = json_encode($images);
            //Gán ID của sản phẩm vừa tạo để liên kết ảnh với sản phẩm.
            $product_image->idProduct = $get_pd->idProduct;
            $product_image->save();

            $product->QuantityTotal = $product_qty;//tổng số lượng đã tính từ các biến thể vào cột
            $product->save();
            return redirect()->back()->with('message', 'Thêm sản phẩm thành công');
        }
    }

    // Sửa sản phẩm
    public function submit_edit_product(Request $request, $idProduct)
    {
        $data = $request->all();    //lấy dữ liệu từ form sửa
        $product = Product::find($idProduct);   // tìm sản phẩm sửa = id
        //Kiểm tra xem có sản phẩm khác (ngoại trừ chính nó) có slug trùng không. Nếu có → không cho sửa.
        $select_product = Product::where('ProductSlug', $data['ProductSlug'])->whereNotIn('idProduct', [$idProduct])->first();

        if ($select_product) {
            return redirect()->back()->with('error', 'Sản phẩm này đã tồn tại');
        } else {
            //Gán các giá trị mới từ form vào bản ghi sản phẩm.
            $product_image = new ProductImage();
            $product->ProductName = $data['ProductName'];
            $product->idCategory = $data['idCategory'];
            $product->idBrand = $data['idBrand'];
            $product->Price = $data['Price'];
            $product->ShortDes = $data['ShortDes'];
            $product->DesProduct = $data['DesProduct'];
            $product->ProductSlug = $data['ProductSlug'];

            $product->save();   //lưu thông tin vào dtb

            // Sửa giá trị thuộc tính sản phẩm

            //Lấy JSON các thuộc tính sản phẩm từ form và decode thành mảng.
            $data_options = $request->input('data_options');
            $data_options = json_decode($data_options, true);

            //Bắt đầu duyệt từng thuộc tính
            $product_qty = 0;
            foreach ($data_options as $data_option) {
                //Mã hóa lại giá trị biến thể (để lưu vào DB, ví dụ "{"size":"M","color":"Red"}").
                $data_values = json_encode($data_option['_options'], JSON_THROW_ON_ERROR);
                //Lấy số lượng tương ứng với biến thể đó.
                $quantity = $data_option['quantity'];
                //Kiểm tra xem biến thể đã tồn tại chưa. Nếu chưa có thì tạo mới bản ghi.
                $product_option = ProductAttriBute::where('idProduct', $idProduct)->where('AttrValue', $data_values)->first();
                if (!$product_option) {
                    $product_option = new ProductAttriBute();
                }
                //Cập nhật và lưu thông tin thuộc tính (biến thể) sản phẩm.
                $product_option->Quantity = $quantity;
                $product_option->idProduct = $idProduct;
                $product_option->AttrValue = $data_values;

                $product_option->save();
                //Tính tổng số lượng của tất cả biến thể để cập nhật
                $product_qty += $quantity;
            }

            // Thêm hình ảnh vào table ProductImage
            if ($request->file('ImageName')) {  //Nếu có upload ảnh mới, bắt đầu xử lý.
                $get_image = $request->file('ImageName');
                $images = [];

                foreach ($get_image as $image) {
                    $get_name_image = $image->getClientOriginalName(); // lấy tên gốc
                    $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);// bỏ đuôi . hình
                    $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();//tên ngẫu nhiên
                    $image->storeAs('public/kidoldash/images/product', $new_image); // lưu thư mục
                    $images[] = $new_image; // thêm vào mảng
                }

                // Xoá hình cũ trong folder và database
                $get_old_mg = ProductImage::where('idProduct', $idProduct)->first();
                if ($get_old_mg) {
                    ProductImage::where('idProduct', $idProduct)->delete();
                }
                //Lưu danh sách ảnh mới vào bảng ProductImage (định dạng JSON).
                $product_image->ImageName = json_encode($images);
                $product_image->idProduct = $idProduct;
                $product_image->save();
            }
            //Cập nhật tổng số lượng sản phẩm dựa trên các biến thể.
            $product->QuantityTotal = $product_qty;
            $product->save();
            return redirect()->back()->with('message', 'Sửa sản phẩm thành công');
        }
    }

    // Xóa sản phẩm
    public function delete_product($idProduct)
    {   
        //Lấy bản ghi hình ảnh sản phẩm từ bảng ProductImage ứng với ID sản phẩm.
        $get_old_mg = ProductImage::where('idProduct', $idProduct)->first();
        foreach (json_decode($get_old_mg->ImageName) as $old_img) { //chuyển chuỗi JSON (chứa mảng tên ảnh) thành mảng.
            Storage::delete('public/kidoldash/images/product/' . $old_img);//Duyệt qua từng ảnh cũ và xoá file ảnh khỏi thư mục
        }
        Product::find($idProduct)->delete();//Tìm bản ghi sản phẩm theo ID và xoá sản phẩm khỏi database.
        return redirect()->back();
    }

    // Ẩn / Hiện sản phẩm
    public function change_status_product(Request $request, $idProduct)
    {
        $data = $request->all();    //lấy toàn bộ dữ liệu từ request
        //Tìm bản ghi sản phẩm cần thay đổi trạng thái dựa trên ID.
        $product = Product::find($idProduct);
        //Gán trạng thái mới (ẩn hoặc hiện) vào cột StatusPro của sản phẩm.(0: ẩn, 1: hiện)
        $product->StatusPro = $data['StatusPro'];
        $product->save();
    }

    // Thêm khuyến mãi
    public function submit_add_sale(Request $request)
    {
        $data = $request->all();
        //Lặp qua từng sản phẩm được chọn để xử lý khuyến mãi riêng cho từng cái.
        foreach ($data['chk_product'] as $chk_product) {
            //Kiểm tra xem sản phẩm này đã có khuyến mãi chưa, nếu có thì lấy bản ghi mới nhất (có SaleEnd gần nhất).
            //→ Dùng để kiểm tra có bị trùng thời gian khuyến mãi hay không.
            $check_time_sale = SaleProduct::join('product', 'product.idProduct', '=', 'saleproduct.idProduct')
                ->where('saleproduct.idProduct', $chk_product)->orderBy('SaleEnd', 'desc')->first();
            
            //Nếu tồn tại khuyến mãi vẫn còn hiệu lực (tức ngày kết thúc lớn hơn hoặc bằng ngày bắt đầu khuyến mãi mới),
            //→ Thì không cho phép thêm, vì bị trùng thời gian.
            if ($check_time_sale && $check_time_sale['SaleEnd'] >= $data['SaleStart']) {
                return redirect()->back()->with('error', 'Thêm khuyến mãi thất bại, sản phẩm ' . $check_time_sale['ProductName'] . ' đã có khuyến mãi trong thời gian trên.<br>Vui lòng thêm khuyến mãi sau ngày ' . $check_time_sale['SaleEnd'] . '.');
            } else {    // nếu k trùng
                //Tạo mảng $data_all chứa toàn bộ dữ liệu cần để insert vào bảng saleproduct
                $data_all = array(
                    'SaleName' => $data['SaleName'],
                    'SaleStart' => $data['SaleStart'],
                    'SaleEnd' => $data['SaleEnd'],
                    'Percent' => $data['Percent'],
                    'idProduct' => $chk_product,
                    'created_at' => now(),
                    'updated_at' => now()
                );
                SaleProduct::insert($data_all);//Thêm dữ liệu khuyến mãi vào bảng saleproduct cho sản phẩm hiện tại.
            }
        }
        return redirect()->back()->with('message', 'Thêm khuyến mãi thành công');
    }

    // Sửa khuyến mãi
    public function submit_edit_sale(Request $request, $idSale, $idProduct)
    {
        $saleproduct = SaleProduct::find($idSale);// Lấy dữ liệu khuyến mãi từ DB theo idSale.
        $data = $request->all();// Lấy toàn bộ dữ liệu gửi lên từ form chỉnh sửa.
        // Gán các giá trị mới từ form vào bản ghi saleproduct.
        $saleproduct->SaleName = $data['SaleName'];
        $saleproduct->SaleStart = $data['SaleStart'];
        $saleproduct->SaleEnd = $data['SaleEnd'];
        $saleproduct->Percent = $data['Percent']; // %giảm

        // Kiểm tra xem các khuyến mãi khác (ngoại trừ cái đang chỉnh sửa) có tồn tại không
        // để xác định cần kiểm tra trùng thời gian hay không.
        $count_check = SaleProduct::where('idProduct', $idProduct)->whereNotIn('idSale', [$idSale])->count();

        // Nếu sản phẩm đã có ít nhất 1 khuyến mãi khác, thì tiếp tục kiểm tra trùng thời gian.
        if ($count_check >= 1) {
            // Lấy toàn bộ các khuyến mãi khác của sản phẩm (ngoại trừ khuyến mãi đang sửa) để kiểm tra trùng thời gian.
            $check_time_sale = SaleProduct::join('product', 'product.idProduct', '=', 'saleproduct.idProduct')
                ->where('saleproduct.idProduct', $idProduct)->whereNotIn('idSale', [$idSale])->get();

            // Duyệt từng khuyến mãi cũ để kiểm tra có chồng thời gian với khuyến mãi mới không.
            foreach ($check_time_sale as $check) {
                // Trường hợp 1: Ngày bắt đầu hoặc ngày kết thúc của khuyến mãi mới nằm trong khoảng thời gian của khuyến mãi cũ.
                if (($check['SaleStart'] <= $data['SaleStart'] && $data['SaleStart'] <= $check['SaleEnd']) || ($check['SaleStart'] <= $data['SaleEnd'] && $data['SaleEnd'] <= $check['SaleEnd'])) {
                    return redirect()->back()->with('error', 'Sửa khuyến mãi thất bại, sản phẩm này đã có khuyến mãi trong thời gian ' . $check['SaleStart'] . ' đến ' . $check['SaleEnd'] . '.');
                } 
                // Trường hợp 2: Khoảng thời gian khuyến mãi mới bao trùm toàn bộ hoặc một phần khoảng cũ → vẫn là trùng.
                else if (($data['SaleStart'] <= $check['SaleStart'] && $check['SaleStart'] <= $data['SaleEnd']) || ($data['SaleStart'] <= $check['SaleEnd'] && $check['SaleEnd'] <= $data['SaleEnd'])) {
                    return redirect()->back()->with('error', 'Sửa khuyến mãi thất bại, sản phẩm này đã có khuyến mãi trong thời gian ' . $check['SaleStart'] . ' đến ' . $check['SaleEnd'] . '.');
                }
            }
        }
        $saleproduct->save();// Nếu không bị trùng thời gian, tiến hành lưu bản ghi sửa đổi vào DB.
        return redirect()->back()->with('message', 'Sửa khuyến mãi thành công');
    }

    // Xóa khuyến mãi
    public function delete_sale($idSale)
    {
        SaleProduct::find($idSale)->delete();//tìm saleproduct theo khóa chính idsale, gọi delete xóa khỏi csdl
        return redirect()->back();
    }

    // Thêm mã giảm giá
    public function submit_add_voucher(Request $request)
    {
        $data = $request->all(); // lấy dữ liệu từ form

        $select_voucher = Voucher::where('VoucherCode', $data['VoucherCode'])->first();//kiểm tra trùng mã voucher ko
        
        if ($select_voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá này đã tồn tại');
        } else {
            // tạo đối tượng voucher mới
            $voucher = new Voucher();
            //gán giá trị từ form vào đối tượng
            $voucher->VoucherName = $data['VoucherName']; // tên mã giảm
            $voucher->VoucherQuantity = $data['VoucherQuantity'];   // số lượng
            $voucher->VoucherCondition = $data['VoucherCondition']; //hình thức
            $voucher->VoucherNumber = $data['VoucherNumber'];   // phần trăm, số tiền giảm
            $voucher->VoucherCode = $data['VoucherCode'];   // mã giảm
            $voucher->VoucherStart = $data['VoucherStart']; //thời gian bắt đầu
            $voucher->VoucherEnd = $data['VoucherEnd']; // thời gian kết thúc
            $voucher->save(); // lưu csdl

            return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
        }
    }

    // Sửa mã giảm giá
    public function submit_edit_voucher(Request $request, $idVoucher)
    {
        $data = $request->all();//lấy dữ liệu form sửa
        // kiểm tra có trùng ko
        $select_voucher = Voucher::where('VoucherCode', $data['VoucherCode'])->whereNotIn('idVoucher', [$idVoucher])->first();

        if ($select_voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá này đã tồn tại');
        } else {
            // cập nhật các thuộc tính mới
            $voucher = Voucher::find($idVoucher);
            $voucher->VoucherName = $data['VoucherName'];// tên mã giảm
            $voucher->VoucherQuantity = $data['VoucherQuantity'];// số lượng
            $voucher->VoucherCondition = $data['VoucherCondition'];//hình thức
            $voucher->VoucherNumber = $data['VoucherNumber'];// phần trăm, số tiền giảm
            $voucher->VoucherCode = $data['VoucherCode'];// mã giảm
            $voucher->VoucherStart = $data['VoucherStart'];//thời gian bắt đầu
            $voucher->VoucherEnd = $data['VoucherEnd'];// thời gian kết thúc
            $voucher->save();

            return redirect()->back()->with('message', 'Sửa mã giảm giá thành công');
        }
    }

    // Xóa giảm giá
    public function delete_voucher($idVoucher)
    {
        Voucher::destroy($idVoucher);//Dùng Eloquent để xoá luôn bản ghi theo ID.
        return redirect()->back();
    }

    /* ---------- End Admin ---------- */

    /* ---------- Shop ---------- */

    // Chuyển đến trang chi tiết sản phẩm
    public function show_product_details($ProductSlug)
    {
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
        // lấy danh mục và thương hiệu để hiển thị giao diện
        $list_category = Category::get();
        $list_brand = Brand::get();
        //lấy sản phẩm từ productslug truyền từ url
        $this_pro = Product::where('ProductSlug', $ProductSlug)->first();
        // kiểm tra sản phẩm có được hiển thị không, nếu !=0 là đang hiển thị - hoạt động
        if ($this_pro->StatusPro != '0') {
            $viewer = new Viewer();
            //xác định người dùng
            if (Session::get('idCustomer') == '') $idCustomer = session()->getId();//dùng session()->getId();khách chưa đăng nhập
            else $idCustomer = (string)Session::get('idCustomer');  // khách đã đăng nhập

            $viewer->idCustomer = $idCustomer;
            $viewer->idProduct = $this_pro->idProduct;
            // kiểm tra xem khách xem sản phẩm đó chưa
            if (Viewer::where('idCustomer', $idCustomer)->where('idProduct', $this_pro->idProduct)->count() == 0) {//chưa xem thì lưu vào bản viewer 
                if (Viewer::where('idCustomer', $idCustomer)->count() >= 3) {
                    $idView = Viewer::where('idCustomer', $idCustomer)->orderBy('idView', 'asc')->take(1)->delete();
                    $viewer->save(); // nếu đã có xem 3sp rồi thì sẽ xóa sp đầu tiên. thêm cái mới.
                } else $viewer->save(); // chưa đến 3=> thêm thẳng
            }
            // lấy thông tin thương hiệu, danh mục, số lượt yêu thích
            $idBrand = $this_pro->idBrand;
            $idCategory = $this_pro->idCategory;
            $count_wish = WishList::where('idProduct', $this_pro->idProduct)->count();

            // lấy danh sách thuộc tính sản phẩm (attribute value và attribute)
            $list_pd_attr = ProductAttriBute::join('attribute_value', 'attribute_value.idAttrValue', '=', 'product_attribute.idAttrValue')
                ->join('attribute', 'attribute.idAttribute', '=', 'attribute_value.idAttribute')
                ->where('product_attribute.idProduct', $this_pro->idProduct)->get();
            //lấy tên một thuộc tính đầu tiên
            $name_attribute = ProductAttriBute::join('attribute_value', 'attribute_value.idAttrValue', '=', 'product_attribute.idAttrValue')
                ->join('attribute', 'attribute.idAttribute', '=', 'attribute_value.idAttribute')
                ->where('product_attribute.idProduct', $this_pro->idProduct)->first();
            // lấy thông tin à hình ảnh đi kèm để hiển thị chi tiết
            $product = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')->where('product.idProduct', $this_pro->idProduct)->first();

            // Lấy danh sách các sản phẩm cùng danh mục
            $list_related_product = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
                ->where('product.idCategory', $this_pro->idCategory)    //lấy sản phẩm cùng danh mục
                ->where('product.idProduct', '!=', $this_pro->idProduct)    //ko lấy chính sản phẩm hiện tại
                ->where('StatusPro', '1')   //trạng thái sp 1
                ->select('ImageName', 'product.*')   //lấy ảnh+ thông tin sản phẩm
                ->get();

            // Lấy danh sách các sản phẩm cùng màu
            $pd_colors = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
                // tìm các sản phẩm giống nhau trong 18 ký tự đầu
                ->where('ProductName', 'LIKE', substr($this_pro->ProductName, 0, 18) . '%')
                ->where(function ($query) use ($this_pro) {
                    $query->where('idBrand', $this_pro->idBrand)    // cùng thương hiệu
                        ->orWhere('idCategory', $this_pro->idCategory); // cùng danh mục
                })
                ->where('product.idProduct', '!=', $this_pro->idProduct)
                ->where('StatusPro', '1')
                ->select('ImageName', 'product.*')
                ->get();
                // đếm số lượng cùng màu tìm được
            $pd_color_count = $pd_colors->count();

            // Tìm danh sách giá trị thuộc tính của sản phẩm

            //lấy toàn bộ dòng trong bản productAttribute. mỗi dòng chứa idAttriValue.vd: màu đỏ - size35
            $product_options = ProductAttriBute::where('idProduct', $product->idProduct)->get();

            $array_value = []; 
            foreach ($product_options as $option) {
                $op = $option->AttrValue;//AttrValue là JSON string chứa dữ liệu như:{"Color": "đỏ"}, {"Size": "35"}.

                $array_value[] = json_decode($op, true);  //decode JSON thành mảng PHP, sau đó thêm vào $array_value
            }
            //gọi hàm mergeOption để gom toàn bộ giá trị thành một mảng duy nhất theo key
            $ops = $this->mergeOption($array_value);
            //Chuyển object $product thành mảng để dễ truyền dữ liệu vào view và gán thêm dữ liệu phụ.
            $productArray = $product->toArray();
        
            $productArray['list_options'] = $product_options->toArray(); //list)op: ds chi tiết từ bản ghi option
            $productArray['options'] = $ops;   // dạng nhóm xử lý để dễ hiển thị

            return view("shop.product.shop-single")->with(compact('list_category', 'list_brand', 'productArray', 'product', 'list_pd_attr', 'name_attribute', 'count_wish', 'list_related_product', 'pd_colors', 'pd_color_count'));
        } else return Redirect::to('home')->send();
    }

    private function mergeOption($array_value)
    {
        $n = count($array_value);   // khởi tạo
        $result = [];
        if ($n == 0) {
            return $result;
        }   // mảng trống thì trả về mảng rỗng

        foreach ($array_value as $value) {  //array_Value chứa nhiều Json decode
            //mỗi item có attribute_item (id loạithuộc tính - màu hoặc size) và property_item (id giá trị -red ,blue, 35)
            foreach ($value as $key => $item) { 
                $attribute_id = $item['attribute_item'];
                $property_id = $item['property_item'];
                
                // lấy thông tin chi tiết từ bảng Attribute và AttributeValue
                $attribute = Attribute::find($attribute_id);
                $property = AttributeValue::find($property_id);
                // kiểm tra 2 biến này có null hoặc tồn tại hay không, nếu ko tồn tại thì dừng vòn lặp
                if (!$attribute || !$property) {
                    break;
                }

                $attribute_name = $attribute->AttributeName;//gán tên thuộc tính cho biến
                $property_name = $property->AttrValName;//gán tên giá trị cho biến

                // đưa vào mảng result  
                if (!isset($result[$attribute_name])) {
                    $result[$attribute_name] = [
                        "attribute" => $attribute->toArray(),
                        "properties" => []
                    ];
                }

                $result[$attribute_name]['properties'][] = $property->toArray();

                $properties = $result[$attribute_name]['properties'];
                // gọi hàm removeDuplicates loại bỏ trùng lặp
                $cleanArray = $this->removeDuplicates($properties);
                $result[$attribute_name]['properties'] = $cleanArray;
            }
        }
        // sắp xếp
        foreach ($result as $group) {
            sort($group['properties']);
        }

        return array_values($result);
    }
    //Tạo mảng $unique với key là idAttrValue, thuộc tính sản phẩm có trùng thì tự động ghi đè → giữ lại duy nhất
    private function removeDuplicates($array)
    {
        $unique = [];
        foreach ($array as $item) {
            $unique[$item['idAttrValue']] = $item;
        }
        return array_values($unique);
    }

    // Chuyển đến trang cửa hàng
    public function show_all_product()
    {
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

        $sub30days = Carbon::now()->subDays(30)->toDateString();//lấy sản phẩm được tạo trong 30 ngày qua
        $list_category = Category::get();
        $list_brand = Brand::get();

        // $maxPrice = Product::max('Price'); : Lấy ra sp có giá max lên đầu tiên (1)

        // Join 3 bảng: brand, category, productimage để lấy tên thương hiệu, danh mục và hình ảnh, chỉ lấy sp đang hoạt động
        $list_pd_query = Product::join('brand', 'brand.idBrand', '=', 'product.idBrand')
            ->join('category', 'category.idCategory', '=', 'product.idCategory')
            ->join('productimage', 'productimage.idProduct', '=', 'product.idProduct')->where('StatusPro', '1')

            // ->orderByRaw('CASE WHEN product.Price = 2999000 THEN 0 ELSE 1 END, product.Price') : Lấy ra sp có giá theo yêu cầu lên đầu tiên

            // ->orderByRaw("CASE WHEN product.Price = $maxPrice THEN 0 ELSE 1 END, product.Price") : Lấy ra sp có giá max lên đầu tiên (2)

            // ->where('product.Price', '>=' , '1000000') : Lấy ra các sp từ 1tr trở lên

            ->select('ImageName', 'product.*', 'BrandName', 'CategoryName');
        // lọc theo thương hiệu và danh mục
        if (isset($_GET['brand'])) $brand_arr = explode(",", $_GET['brand']); // chia thành mảng các giá trị dựa trên dấu phẩy
        if (isset($_GET['category'])) $category_arr = explode(",", $_GET['category']);

        if (isset($_GET['category']) && isset($_GET['brand'])) {
            $list_pd_query->whereIn('product.idCategory', $category_arr)->whereIn('product.idBrand', $brand_arr);
        } else if (isset($_GET['brand'])) {
            $list_pd_query->whereIn('product.idBrand', $brand_arr);
        } else if (isset($_GET['category'])) {
            $list_pd_query->whereIn('product.idCategory', $category_arr);
        }
        //Lọc theo giá 
        if (isset($_GET['priceMin']) && isset($_GET['priceMax'])) {
            $list_pd_query->whereBetween('Price', [$_GET['priceMin'], $_GET['priceMax']]);
        } else if (isset($_GET['priceMin'])) {
            $list_pd_query->whereRaw('Price >= ?', $_GET['priceMin']);
        } else if (isset($_GET['priceMax'])) {
            $list_pd_query->whereRaw('Price <= ?', $_GET['priceMax']);
        }
        //Sắp xếp
        if (isset($_GET['sort_by'])) {
            if ($_GET['sort_by'] == 'new') $list_pd_query->orderBy('created_at', 'desc');
            else if ($_GET['sort_by'] == 'old') $list_pd_query->orderBy('created_at', 'asc');// cũ nhất
            else if ($_GET['sort_by'] == 'bestsellers') $list_pd_query->orderBy('Sold', 'desc');// bán chạy
            // sản phẩm bán chạy (tạo trong 30 ngày)
            else if ($_GET['sort_by'] == 'featured') $list_pd_query->whereBetween('product.created_at', [$sub30days, now()])->orderBy('Sold', 'desc');
            //đang trong thời gian giảm giá
            else if ($_GET['sort_by'] == 'sale') $list_pd_query->join('saleproduct', 'saleproduct.idProduct', '=', 'product.idProduct')->whereRaw('SaleStart < NOW()')->whereRaw('SaleEnd > NOW()')->orderBy('created_at', 'desc');
            //giá cao -> thấp
            else if ($_GET['sort_by'] == 'price_desc') $list_pd_query->orderBy('Price', 'desc');
            // giá thấp -> cao
            else if ($_GET['sort_by'] == 'price_asc') $list_pd_query->orderBy('Price', 'asc');
        } else $list_pd_query->orderBy('created_at', 'desc');//mặc định mới nhất lên đầu

        //Đếm các sản phẩm hiện có
        $count_pd = $list_pd_query->count();

        //Lấy ra danh sách gồm 15 sản phẩm
        $list_pd = $list_pd_query->paginate(15);

        //Lấy 3 sản phẩm có Sold > 0, sắp xếp theo số lượng đã bán giảm dần.
        $top_bestsellers_pd = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->where('Sold', '>', 0)->orderBy('Sold', 'DESC')->limit(3)->get();

        return view("shop.product.shop-all-product")->with(compact('list_category', 'list_brand', 'list_pd', 'count_pd', 'top_bestsellers_pd'));
    }

    // Hiện modal quick view sản phẩm
    public function quick_view_pd(Request $request)
    {
        if ($request->ajax()) {//Đảm bảo chỉ xử lý khi request được gửi bằng AJAX (tức là không load lại trang).
            $data = $request->all();
            $output = '';
            //Lấy thông tin một sản phẩm duy nhất dựa theo idProduct, kết hợp bảng ảnh (productimage) để có hình ảnh.
            $product = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')->where('product.idProduct', $data['idProduct'])->first();

            //Lấy thông tin giảm giá nếu đang trong thời gian khuyến mãi.
            $sale_pd = SaleProduct::where('idProduct', $data['idProduct'])->whereRaw('SaleStart < NOW()')->whereRaw('SaleEnd > NOW()')->first();
            
            //Nếu có khuyến mãi → tính giá giảm = giá gốc – % giảm.
            $SalePrice = 0;
            if ($sale_pd) $SalePrice = $product->Price - ($product->Price / 100) * $sale_pd->Percent;
            //Vì ImageName là dạng JSON chứa nhiều ảnh, nên lấy ảnh đầu tiên để hiển thị nhanh.
            $image = json_decode($product->ImageName)[0];

            $output .= '
                    <div class="modal fade" id="modal-pd-' . $data['idProduct'] . '">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="quick-view-image">
                                                <img src="public/storage/kidoldash/images/product/' . $image . '" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="quick-view-content">
                                                <h4 class="product-title">' . $product->ProductName . '</h4>';

            $output .= '<div class="thumb-price">';
            if ($SalePrice != '0') {
                //giá gốc               discount: % giảm
                $output .= '<span class="old-price">' . number_format($product->Price, 0, ',', '.') . 'đ</span>
                                                    <span class="current-price">' . number_format(round($SalePrice, -3), 0, ',', '.') . 'đ</span>
                                                    <span class="discount">-' . $sale_pd->Percent . '%</span> 
                                                </div>';
            } else {
                // giá khuyến mãi
                $output .= '<span class="current-price">' . number_format($product->Price, 0, ',', '.') . 'đ</span>
                                                </div>';
            }
            // mô tả ngắn
            $output .= ' <div>' . $product->ShortDes . '</div>
                                                <div class="mt-3">
                                                    <a href="shop-single/' . $product->ProductSlug . '" class="btn btn-primary">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
        }
        echo $output;
    }

    // Lấy thời gian khuyến mãi của 1 sản phẩm
    public static function get_sale_pd($idProduct)
    {
        $get_sale_pd = SaleProduct::where('idProduct', $idProduct)->whereRaw('SaleStart < NOW()')->whereRaw('SaleEnd > NOW()')->first();
        return $get_sale_pd;
    }

    // Hiện modal so sánh sản phẩm
    public function modal_compare(Request $request)
    {
        $data = $request->all();
        $output = '';

        $get_pd = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->where('StatusPro', '1')->where('idCategory', $data['idCategory'])
            ->whereNotIn('product.idProduct', [$data['idProduct']])->get();

        $output .= '
                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header justify-content-start">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Chọn sản phẩm</h5>
                                <input type="text" id="search-pd-compare" placeholder="Tìm kiếm sản phẩm" style="width:65%; margin-left:10%;">
                            </div>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
                            <div class="modal-body modal-compare-body row">';
        foreach ($get_pd as $key => $pd) {
            $sale_pd = SaleProduct::where('idProduct', $pd->idProduct)->whereRaw('SaleStart < NOW()')->whereRaw('SaleEnd > NOW()')->first();
            $SalePrice = $pd->Price;
            if ($sale_pd) $SalePrice = $pd->Price - ($pd->Price / 100) * $sale_pd->Percent;
            $image = json_decode($pd->ImageName)[0];
            $output .= '    <div class="product-item col-md-3 select-pd" id="product-item-' . $pd->idProduct . '" data-id="' . $pd->idProduct . '">
                                <div class="product-image-compare mb-3" id="product-image-' . $pd->idProduct . '">
                                    <label for="chk-pd-' . $pd->idProduct . '"><img src="public/storage/kidoldash/images/product/' . $image . '" class="rounded w-100 img-fluid"></label>
                                    <div class="product-title-compare">
                                        <div class="product-name-compare text-center">
                                            <input type="checkbox" class="checkstatus d-none" id="chk-pd-' . $pd->idProduct . '" name="chk_product[]" value="' . $pd->idProduct . '" data-id="' . $pd->idProduct . '">
                                            <span>' . $pd->ProductName . '</span>
                                        </div>
                                        <div style="text-align:center;">' . number_format(round($SalePrice, -3), 0, ',', '.') . 'đ</div>
                                    </div>
                                </div>
                                <input type="hidden" name="selected_product[]" id="product-' . $pd->idProduct . '" value="">
                            </div>';
        }

        $output .= '    </div>
                            <div class="modal-footer">
                                <button type="button" id="confirm" class="btn btn-primary btn-round btn-compare" data-dismiss="modal" style="pointer-events: none; background-color: rgb(108, 117, 125); border:none;">Xác nhận</button>
                                <button type="button" class="btn btn-round" style="color:#000; border: 1px solid #e6e6e6;" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>';
        echo $output;
    }

    // Tìm kiếm sản phẩm so sánh
    public function modal_compare_search(Request $request)
    {
        $data = $request->all(); //lấy dữ liệu từ request
        $value = $data['value']; // từ khóa tìm
        $output = '';
        //tạo query sản phẩm phù hợp
        $pds = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->join('brand', 'brand.idBrand', '=', 'product.idBrand')
            ->where('StatusPro', '1')->where('idCategory', $data['idCategory']) // còn hoạt động, cùng danh mục
            ->whereNotIn('product.idProduct', [$data['idProduct']])// ko gồm chính sản phẩm hiện tại
            ->select('ImageName', 'product.*', 'BrandName');
        // thêm điều kiện tìm kiếm theo từ khóa
        $pds->where(function ($pds) use ($value) {
            $pds->whereRaw("MATCH (ProductName) AGAINST (?)", Product::fullTextWildcards($value));
        });
        // lấy kq sản phẩm phù hợp
        $get_pd = $pds->get();

        foreach ($get_pd as $key => $pd) {
            //Lấy thông tin giảm giá nếu đang trong thời gian khuyến mãi.
            $sale_pd = SaleProduct::where('idProduct', $pd->idProduct)->whereRaw('SaleStart < NOW()')->whereRaw('SaleEnd > NOW()')->first();
            $SalePrice = $pd->Price;
            //Nếu có khuyến mãi → tính giá giảm = giá gốc – % giảm.
            if ($sale_pd) $SalePrice = $pd->Price - ($pd->Price / 100) * $sale_pd->Percent;
            // lấy hình ảnh đầu tiên trong mảng ảnh json
            $image = json_decode($pd->ImageName)[0];
            //Tạo một khối sản phẩm (div) chiếm 3 cột (col-md-3) → 4 sản phẩm mỗi hàng.
            //select-pd: class dùng để gắn JavaScript khi người dùng chọn sản phẩm
            //data-id chứa id sản phẩm → để JavaScript lấy ra sau này.
            $output .= '<div class="product-item col-md-3 select-pd" id="product-item-' . $pd->idProduct . '" data-id="' . $pd->idProduct . '">
                            <div class="product-image-compare mb-3" id="product-image-' . $pd->idProduct . '">
                                <label for="chk-pd-' . $pd->idProduct . '"><img src="/public/storage/kidoldash/images/product/' . $image . '" class="rounded w-100 img-fluid"></label>
                                <div class="product-title-compare">
                                    <div class="product-name-compare text-center">
                                        <input type="checkbox" class="checkstatus d-none" id="chk-pd-' . $pd->idProduct . '" name="chk_product[]" value="' . $pd->idProduct . '" data-id="' . $pd->idProduct . '">
                                        <span>' . $pd->ProductName . '</span>
                                    </div>
                                    <div style="text-align:center;">' . number_format(round($SalePrice, -3), 0, ',', '.') . 'đ</div>
                                </div>
                            </div>
                            <input type="hidden" name="selected_product[]" id="product-' . $pd->idProduct . '" value="">
                        </div>';
            //product-image-compare : hiển thị ảnh đầu tiên sản phẩm, Gói trong thẻ <label> để khi bấm vào ảnh sẽ chọn checkbox tương ứng.
            //product-name-compare text-center: tên sản phẩm và checkbox
        }   //<input type="hidden": Dùng để lưu sản phẩm được chọn, khi gửi form so sánh.
        echo $output;
    }

    // Gợi ý tìm kiếm sản phẩm
    public function search_suggestions(Request $request)
    {
        $value = $request->value; // lấy dữ liệu từ khóa ng dùng nhập

        $output = '';
        // lấy 3 danh mục gợi ý
        $get_cat = Category::select('CategoryName')->where('CategoryName', 'like', '%' . $value . '%')->limit(3)->get();
        // lấy 3 thương hiệu gợi ý
        $get_brand = Brand::select('BrandName')->where('BrandName', 'like', '%' . $value . '%')->limit(3)->get();
        // tìm sản phẩm có tên giống từ khóa
        $pds = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->join('brand', 'brand.idBrand', '=', 'product.idBrand')
            ->join('category', 'category.idCategory', '=', 'product.idCategory')
            ->where('StatusPro', '1')
            ->whereRaw("MATCH (ProductName) AGAINST (?)", Product::fullTextWildcards($value))
            ->select('ImageName', 'ProductName', 'ProductSlug');
        // nếu ko tìm thấy bằng fulltext:Tìm sản phẩm theo tên thương hiệu hoặc danh mục nếu không có kết quả từ tên sản phẩm.
        if ($pds->count() < 1) {
            $pds = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
                ->join('brand', 'brand.idBrand', '=', 'product.idBrand')
                ->join('category', 'category.idCategory', '=', 'product.idCategory')
                ->where('StatusPro', '1')
                ->select('ImageName', 'ProductName', 'BrandName', 'CategoryName', 'ProductSlug');
            $pds->where(function ($pds) use ($value) {
                $pds->orWhere('BrandName', 'like', '%' . $value . '%')->orWhere('CategoryName', 'like', '%' . $value . '%');
            });
        }

        $get_pd = $pds->limit(3)->get();
        // gợi ý danh mục
        if ($get_cat->count() > 0) {
            $output .= '<h5 class="p-1">Danh mục</h5>';
            foreach ($get_cat as $cat) {
                $output .= '
                    <li class="search-product-item">
                        <a class="search-product-text one-line" href="search?keyword=' . $cat->CategoryName . '">' . $cat->CategoryName . '</a>
                    </li>';
            }
        }
        // gợi ý thương hiệu
        if ($get_brand->count() > 0) {
            $output .= '<h5 class="p-1">Thương hiệu</h5>';
            foreach ($get_brand as $brand) {
                $output .= '
                    <li class="search-product-item">
                        <a class="search-product-text one-line" href="search?keyword=' . $brand->BrandName . '">' . $brand->BrandName . '</a>
                    </li>';
            }
        }
        // gợi ý sản phẩm
        if ($get_pd->count() > 0) {
            $output .= '<h5 class="p-1">Sản phẩm</h5>';
            foreach ($get_pd as $pd) {
                $image = json_decode($pd->ImageName)[0];
                $output .= '
                    <li class="search-product-item d-flex align-items-center">
                        <a class="search-product-text" href="/../kidolshop/shop-single/' . $pd->ProductSlug . '">
                            <div class="d-flex align-items-center">
                                <img width="50" height="50" src="/../kidolshop/public/storage/kidoldash/images/product/' . $image . '" alt="">
                                <span class="two-line ml-2">' . $pd->ProductName . '</span>
                            </div>
                        </a>
                    </li>';
            }
        }
        echo $output;
    }

    /* ---------- End Shop ---------- */
}
