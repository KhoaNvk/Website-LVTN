<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\AddressCustomer;
use App\Events\NewOrderEvent;
use App\Models\Bill;
use App\Models\BillHistory;
use App\Models\BillInfo;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Statistic;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /* ---------- Admin ---------- */

    // Kiểm tra đăng nhập
    public function checkLogin_Admin()
    {
        $idAdmin = Session::get('idAdmin');
        if ($idAdmin == false) return Redirect::to('admin')->send();
    }

    // Hiện tất cả đơn đặt hàng
    public function list_bill()
    {
        $this->checkLogin_Admin();
        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')->whereNotIn('bill.Status', [99])
            ->select('customer.username', 'customer.PhoneNumber as CusPhone', 'bill.*')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.list-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện tất cả đơn đặt hàng đang chờ xác nhận
    public function waiting_bill()
    {
        $this->checkLogin_Admin();

        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')->where('bill.Status', '0')
            ->select('bill.*', 'customer.username', 'customer.PhoneNumber as CusPhone')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.waiting-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện tất cả đơn đặt hàng đang giao
    public function shipping_bill()
    {
        $this->checkLogin_Admin();

        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->join('billhistory', 'billhistory.idBill', '=', 'bill.idBill')->where('bill.Status', '1')
            ->select('bill.*', 'customer.username', 'customer.PhoneNumber as CusPhone', 'billhistory.AdminName', 'billhistory.created_at AS TimeConfirm')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.shipping-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện tất cả đơn đặt hàng đã giao
    public function shipped_bill()
    {
        $this->checkLogin_Admin();

        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')->where('bill.Status', '2')
            ->select('bill.*', 'customer.username', 'customer.PhoneNumber as CusPhone')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.shipped-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện tất cả đơn đặt hàng đã hủy
    public function cancelled_bill()
    {
        $this->checkLogin_Admin();

        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->join('billhistory', 'billhistory.idBill', '=', 'bill.idBill')->where('bill.Status', '99')
            ->select('bill.*', 'customer.username', 'customer.PhoneNumber as CusPhone', 'billhistory.AdminName', 'billhistory.created_at AS TimeConfirm')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.cancelled-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện tất cả đơn đặt hàng đã xác nhận
    public function confirmed_bill()
    {
        $this->checkLogin_Admin();

        $list_bill = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->join('billhistory', 'billhistory.idBill', '=', 'bill.idBill')->where('billhistory.Status', '1')
            ->select('bill.*', 'customer.username', 'customer.PhoneNumber as CusPhone', 'billhistory.AdminName', 'billhistory.created_at AS TimeConfirm')->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.confirmed-bill")->with(compact('list_bill', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Hiện chi tiết đơn đặt hàng
    public function bill_info($idBill)
    {
        $this->checkLogin_Admin();

        $address = Bill::where('idBill', $idBill)->first();

        $list_bill_info = BillInfo::join('product', 'product.idProduct', '=', 'billinfo.idProduct')
            ->join('productimage', 'productimage.idProduct', '=', 'billinfo.idProduct')
            ->where('billinfo.idBill', $idBill)
            ->select('product.ProductName', 'product.idProduct', 'productimage.ImageName', 'billinfo.*')
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

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
            ->where('Status', '!=', '99')
            ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.bill.bill-info")->with(compact('address', 'list_bill_info', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Xác nhận đơn hàng
    public function confirm_bill(Request $request, $idBill)
    {
        if ($request->Status == 2) { // nếu đơn hàng chuyển thành trạng thái 2 ( đã giao)
            // đặt thời gian nhận hàng là hiện tại, đổi trạng thái thành 2
            Bill::find($idBill)->update(['ReceiveDate' => now(), 'Status' => $request->Status]);
            // tăng số lượng sản phẩm đã bán, lấy tất cả sp trong đơn,với mỗi sản phẩm, tăng Sold lên số lượng đã mua (QuantityBuy).
            $BillInfo = BillInfo::where('idBill', $idBill)->get();
            foreach ($BillInfo as $key => $bi) {
                DB::update('update product set Sold = Sold + ? where idProduct = ?', [$bi->QuantityBuy, $bi->idProduct]);
            }
        } else { // ngược lại khi đơn hàng đang giao- chờ xác nhận
            // chỉ cập nhật trạng thái đơn hàng
            Bill::find($idBill)->update(['Status' => $request->Status]);
            // Lưu lịch sử đơn hàng vào bảng BillHistory: Lưu tên admin thực hiện, trạng thái cập nhật, ID hóa đơn.
            $BillHistory = new BillHistory();
            $BillHistory->idBill = $idBill;
            $BillHistory->AdminName = Session::get('AdminName');
            $BillHistory->Status = $request->Status;
            $BillHistory->save();
        }

        return redirect()->back();
    }

    // Hủy đơn hàng
    public function delete_bill($idBill)
    {   // ghi lịch sử đơn hàng bị hủy
        $BillHistory = new BillHistory();
        $BillHistory->idBill = $idBill;
        $BillHistory->AdminName = Session::get('AdminName');
        $BillHistory->Status = 99;
        $BillHistory->save();
        Bill::find($idBill)->update(['Status' => '99']);    // cập nhật trạng thái hóa đơn thành 99
        // trường hợp hủy đơn khi có dùng mã voucher
        $Bill = Bill::find($idBill);    // lấy mã giảm giá của đơn hàng
        if ($Bill->Voucher != '') { // kiểm tra đơn hàng có voucher ko
            // tách chuỗi voucher: Ví dụ: nếu trong đơn, Voucher = "5-GIAMGIA30K"
            // explode("-", $Bill->Voucher) sẽ tách thành mảng: [5, 'GIAMGIA30K']
            // idVoucher = 5 là ID của mã giảm giá trong bảng voucher.

            $Voucher = explode("-", $Bill->Voucher);
            $idVoucher = $Voucher[0];

            // Vì đơn hàng bị hủy nên voucher không được tính là đã dùng
            // VoucherQuantity là số lượng mã giảm giá còn lại => cần +1 để trả lại cho hệ thống.
            DB::update('update voucher set VoucherQuantity = VoucherQuantity + 1 where idVoucher = ?', [$idVoucher]);
        }
        //Tăng lại số lượng từng thuộc tính sản phẩm (product_attribute) và tổng số lượng (product)
        $BillInfo = BillInfo::where('idBill', $idBill)->get();
        foreach ($BillInfo as $key => $bi) {
            DB::update('update product_attribute set Quantity = Quantity + ? where idProAttr = ?', [$bi->QuantityBuy, $bi->idProAttr]);
            DB::update('update product set QuantityTotal = QuantityTotal + ? where idProduct = ?', [$bi->QuantityBuy, $bi->idProduct]);
        }
    }

    // Đếm số lượng đơn hàng mới đặt
    public static function getNewOrderCount()
    {
        return Bill::where('Status', 0)->count();
    }


    // Lấy các đơn hàng vừa đặt
    public function getNewOrdersData()
    {
        return Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->where(function ($query) {
                $query->where('bill.Status', '0')
                    ->orWhere(function ($query) {
                        $query->where('bill.Status', '1')
                            ->whereIn('bill.Payment', ['vnpay', 'momo']);
                    });
            })
            ->select('bill.created_at', 'customer.username', 'customer.Avatar', 'bill.idBill', 'bill.Payment')
            ->orderBy('bill.created_at', 'desc')
            // ->take(5)
            ->get();
    }

    // Lấy các đơn hàng vừa nhận
    public function getReceivedOrders()
    {
        $today = now()->format('Y-m-d');

        $receivedOrders = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->where('bill.Status', 2)
            ->whereDate('bill.updated_at', $today)
            ->select('bill.updated_at', 'customer.username', 'customer.Avatar', 'bill.idBill', 'bill.Payment')
            ->orderBy('bill.updated_at', 'desc')
            ->get();

        return $receivedOrders;
    }

    // Lấy các đơn hàng vừa hủy
    public function getCancelledOrders()
    {
        $today = now()->format('Y-m-d');

        $cancelledOrders = Bill::join('customer', 'bill.idCustomer', '=', 'customer.idCustomer')
            ->where('bill.Status', 99)
            ->whereDate('bill.updated_at', $today)
            ->select('bill.updated_at', 'customer.username', 'customer.Avatar', 'bill.idBill', 'bill.Payment')
            ->orderBy('bill.updated_at', 'desc')
            ->get();

        return $cancelledOrders;
    }

    /* ---------- End Admin ---------- */

    /* ---------- Shop ---------- */

    // Kiểm tra đăng nhập
    public function checkLogin()
    {
        $idCustomer = Session::get('idCustomer');
        if ($idCustomer == false) return Redirect::to('/home')->send();
    }

    // Hiện tất cả đơn đặt hàng
    public function ordered()
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

        $list_category = Category::get();
        $list_brand = Brand::get();
        
        $list_bill = Bill::where('bill.idCustomer', Session::get('idCustomer'))->orderBy('idBill', 'desc')->get();
        $customer = Customer::find(Session::get('idCustomer'));
        return view("shop.customer.ordered")->with(compact('list_category', 'list_brand', 'list_bill', 'customer'));
    }

    // Hiện tất cả đơn đặt hàng đang chờ xác nhận
    public function order_waiting()
    {
        $this->checkLogin();
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_bill = Bill::where('bill.idCustomer', Session::get('idCustomer'))->where('Status', '0')->get();
        $customer = Customer::find(Session::get('idCustomer'));
        return view("shop.customer.order-waiting")->with(compact('list_category', 'list_brand', 'list_bill', 'customer'));
    }

    // Hiện tất cả đơn đặt hàng đang giao
    public function order_shipping()
    {
        $this->checkLogin();
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_bill = Bill::where('bill.idCustomer', Session::get('idCustomer'))->where('Status', '1')->get();
        $customer = Customer::find(Session::get('idCustomer'));
        return view("shop.customer.order-shipping")->with(compact('list_category', 'list_brand', 'list_bill', 'customer'));
    }

    // Hiện tất cả đơn đặt hàng đã giao
    public function order_shipped()
    {
        $this->checkLogin();
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_bill = Bill::where('bill.idCustomer', Session::get('idCustomer'))->where('Status', '2')->get();
        $customer = Customer::find(Session::get('idCustomer'));
        return view("shop.customer.order-shipped")->with(compact('list_category', 'list_brand', 'list_bill', 'customer'));
    }

    // Hiện tất cả đơn đặt hàng đã hủy
    public function order_cancelled()
    {
        $this->checkLogin();
        $list_category = Category::get();
        $list_brand = Brand::get();
        $list_bill = Bill::where('bill.idCustomer', Session::get('idCustomer'))->where('Status', '99')->get();
        $customer = Customer::find(Session::get('idCustomer'));
        return view("shop.customer.order-cancelled")->with(compact('list_category', 'list_brand', 'list_bill', 'customer'));
    }

    // Hiện chi tiết đơn đặt hàng
    public function ordered_info($idBill)
    {
        $this->checkLogin();
        $list_bill = Bill::where('idBill', $idBill)->where('bill.idCustomer', Session::get('idCustomer'))->whereIn('Status', [1, 2, 0, 99])->get();
        $list_category = Category::get();
        $list_brand = Brand::get();

        $address = Bill::where('idBill', $idBill)->first();

        $list_bill_info = BillInfo::join('product', 'product.idProduct', '=', 'billinfo.idProduct')
            ->join('productimage', 'productimage.idProduct', '=', 'billinfo.idProduct')
            ->where('billinfo.idBill', $idBill)
            ->select('product.ProductName', 'product.idProduct', 'product.ProductSlug', 'productimage.ImageName', 'billinfo.*')
            ->cursor()
            ->map(function ($item) {
                $cart = $item->toArray();
                $product = Product::find($item->idProduct);
                $cart['product'] = $product;

                $val = $item->proAttr;
                $product_option = DB::table('product_attribute')->where('idProAttr', $val)->first();
                if ($product_option) {
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
                }

                $cart['attribute'] = $product_option ?$dataConvert : [];
                $cart['product_option'] = $product_option;
                return (object)$cart;
            })->all();;

        return view("shop.customer.ordered-info")->with(compact('list_bill', 'list_category', 'list_brand', 'address', 'list_bill_info'));
    }

    // Hiện đơn hàng người dùng đã nhận hàng
    public function confirmReceipt(Request $request, $idBill)
    {
        if ($request->Status == 2) {
            Bill::find($idBill)->update(['ReceiveDate' => now(), 'Status' => $request->Status]);

            $BillInfo = BillInfo::where('idBill', $idBill)->get();
            foreach ($BillInfo as $key => $bi) {
                DB::update('update product set Sold = Sold + ? where idProduct = ?', [$bi->QuantityBuy, $bi->idProduct]);
            }
        } else {
            Bill::find($idBill)->update(['Status' => $request->Status]);
            $BillHistory = new BillHistory();
            $BillHistory->idBill = $idBill;
            $BillHistory->AdminName = Session::get('AdminName');
            $BillHistory->Status = $request->Status;
            $BillHistory->save();
        }

        return redirect()->back();
    }
    /* ---------- End Shop ---------- */
}
