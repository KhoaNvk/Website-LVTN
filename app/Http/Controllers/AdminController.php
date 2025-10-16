<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillInfo;
use App\Models\Statistic;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
session_start();

class AdminController extends Controller
{
    // Kiểm tra đăng nhập
    public function checkLogin(){
        $idAdmin = Session::get('idAdmin');
        if($idAdmin == false) return Redirect::to('admin')->send();
    }

    // Kiểm tra chức vụ
    public function checkPostion(){
        $position = Session::get('Position');
        if($position === 'Nhân Viên') return Redirect::to('/my-adprofile')->send();
    }

    // Chuyển đến trang đăng nhập
    public function show_login(){
        if(Session::get('idAdmin')) return Redirect::to('dashboard');
        else return view("admin_login");
    }

    // Chuyển đến trang thống kê
    public function show_dashboard(){
        $this->checkLogin();
        $this->checkPostion();
        $start_this_month = Carbon::now()->startOfMonth()->toDateString();//lấy ngày đầu tiên của tháng hiện tại->lọc hóa đơn/thống kê theo tháng

        $total_revenue = Bill::whereNotIn('Status',[99])->sum('TotalBill');//tính tổng tiền của tất cả hóa đơn
        $total_sell = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('Status',[99])->sum('QuantityBuy');//loại trừ đơn bị hủy
        // top 6 sp bán chạy trong tháng
        $list_topProduct = Product::join('productimage','productimage.idProduct','=','product.idProduct')
            ->join('billinfo','billinfo.idProduct','=','product.idProduct')
            ->join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('Status',[99])
            ->whereBetween('bill.created_at', [$start_this_month,now()])
            ->select('ProductName','ImageName') //lấy tên sp, ảnh sp
            ->selectRaw('sum(QuantityBuy) as Sold')// tính tổng số lượng đã bán
            ->groupBy('ProductName','ImageName')->orderBy('Sold','DESC')->take(6)->get();// lấy 6 sp

        $list_topProduct_AllTime = Product::join('productimage', 'productimage.idProduct', '=', 'product.idProduct')
            ->selectRaw('product.*, productimage.*, (product.Sold * product.Price) as Revenue')
            ->whereRaw('product.Sold > 0')
            ->orderByRaw('Revenue DESC')
            ->take(5)
            ->get();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();

        return view("admin.dashboard")->with(compact('total_revenue','total_sell','list_topProduct','list_topProduct_AllTime', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang hồ sơ cá nhân
    public function my_adprofile(){
        $this->checkLogin();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.my-account.my-adprofile")->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang chỉnh sửa hồ sơ cá nhân
    public function edit_adprofile(){
        $this->checkLogin();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.my-account.edit-adprofile")->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang đổi mật khẩu
    public function change_adpassword(){
        $this->checkLogin();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.my-account.change-adpassword")->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang quản lý nhân viên
    public function manage_staffs(){
        $this->checkLogin();
        $this->checkPostion();
        $list_staff = Admin::whereNotIn('idAdmin', [0])->get();//lấy danh sách nvien
        $count_staff = Admin::whereNotIn('idAdmin', [0])->count();//đếm số lượng nvien 

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.manage-users.manage-staffs")->with(compact('list_staff','count_staff'))->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang thêm nhân viên
    public function add_staffs(){
        $this->checkLogin();
        $this->checkPostion();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.manage-users.add-staffs")->with(compact('count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Chuyển đến trang quản lý tài khoản khách hàng
    public function manage_customers(){
        $this->checkLogin();
        $this->checkPostion();
        $list_customer = Customer::get();
        $count_customer = Customer::count();

        $count_waiting_bill = Bill::where('Status', '0')->count();
        $count_confirmed_bill = Bill::where('Status', '!=', '0')
                        ->where('Status', '!=', '99')
                        ->count();
        $count_shipping_bill = Bill::where('Status', '1')->count();
        $count_shipped_bill = Bill::where('Status', '2')->count();
        $count_cancelled_bill = Bill::where('Status', '99')->count();
        return view("admin.manage-users.manage-customers")->with(compact('list_customer','count_customer', 'count_waiting_bill', 'count_confirmed_bill', 'count_shipping_bill', 'count_shipped_bill', 'count_cancelled_bill'));
    }

    // Khóa / Mở khóa khách hàng
    public function change_status_customer(Request $request, $idCustomer){
        $data = $request->all();    //lấy dữ liệu gửi từ form

        $customer = Customer::find($idCustomer);
        $customer->Status = $data['Status'];    //gán trạng thái mới
        $customer->save();
    }

    // Lấy trạng thái của khách hàng
    public function get_customer_status(Request $request)
    {
        $idCustomer = $request->session()->get('idCustomer');   //lấy idCustomer từ session
        $customer = Customer::find($idCustomer);// tìm khách hàng theo idCustomer

        if ($customer) { //tìm thấy khách hàng
            return response()->json(['status' => $customer->Status]);
        } else { // ngược lại
            return response()->json(['status' => null], 404);
        }
    }

    // Đăng nhập tài khoản
    public function admin_login(Request $request){
        $data = $request->all();    //lấy dữ liệu gửi từ form
        $AdminUser = $data['AdminUser'];
        $AdminPass = md5($data['AdminPass']);

        $login = Admin::where('AdminUser', $AdminUser)->where('AdminPass', $AdminPass)->first();//kiểm tra đăng nhập đúng tk mk đúng ko

        if($login){ // lưu thông tin vào session, chuyển vào dashboard
            Session::put('idAdmin', $login->idAdmin);
            Session::put('AdminUser', $login->AdminUser);
            Session::put('AdminName', $login->AdminName);
            Session::put('Address', $login->Address);
            Session::put('NumberPhone', $login->NumberPhone);
            Session::put('Email', $login->Email);
            Session::put('Avatar', $login->Avatar);
            Session::put('Position', $login->Position);
            return Redirect::to('/dashboard');
        }else{ // ngược lại
            Session::put('message', 'Mật khẩu hoặc tài khoản không đúng!!');
            return Redirect::to('/admin');
        }
    }

    // Đăng xuất tài khoản
    public function admin_logout(){
        $this->checkLogin();
        Session::put('idAdmin', null);  // xóa session lưu idAdmin
        return Redirect::to('/admin');
    }

    // Chỉnh sửa hồ sơ cá nhân
    public function submit_edit_adprofile(Request $request){
        $data = $request->all();    // lấy dữ liệu từ form
        $admin = Admin::find(Session::get('idAdmin'));  //lấy id admin theo session
        // gán giá trị mới 
        $admin->AdminName = $data['AdminName'];
        $admin->NumberPhone = $data['NumberPhone'];
        $admin->Email = $data['Email'];
        $admin->Address = $data['Address'];
        // xử lý avatar (nếu có)
        if ($request->file('Avatar')){
            $get_image = $request->file('Avatar');

            $get_name_image = $get_image->getClientOriginalName();// Lấy tên file gốc
            $name_image = current(explode('.',$get_name_image));// Lấy phần tên không có đuôi
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();// Tạo tên file mới có số random
            $get_image->storeAs('public/kidoldash/images/user',$new_image);// Lưu ảnh vào thư mục
            $admin->Avatar = $new_image;        // lưu đường dẫn avt mới vào session
            Session::put('Avatar', $new_image);
            // xóa file avt cũ
            $get_old_img = Admin::where('idAdmin', Session::get('idAdmin'))->first();
            Storage::delete('public/kidoldash/images/user/'.$get_old_img->Avatar);
        }

        $admin->save(); //lưu dữ liệu vào dtb
        Session::put('AdminName', $data['AdminName']);  // cập nhật session thông tin admin
        Session::put('Address', $data['Address']);
        Session::put('NumberPhone', $data['NumberPhone']);
        Session::put('Email', $data['Email']);
        return redirect()->back()->with('message', 'Sửa hồ sơ thành công');
    }

    // Đổi mật khẩu
    public function submit_change_adpassword(Request $request){
        $data = $request->all();    //lấy dữ liệu từ form
        $admin = Admin::find(Session::get('idAdmin'));  //tìm Admin theo session đăng nhập

        if(md5($data['password']) != $admin->AdminPass){    //kiểm tra mật khẩu cũ nhập từ form dc mã hóa md5
            return redirect()->back()->with('error', 'Nhập mật khẩu cũ không đúng');
        }else{
            $admin->AdminPass = md5($data['newpassword']); // mã hóa mật khẩu mới bằng md5 rồi lưu
            $admin->save();
            return redirect()->back()->with('message', 'Đổi mật khẩu thành công');
        }
    }

    // Thêm nhân viên
    public function submit_add_staffs(Request $request){
        $data = $request->all();    //lấy dữ liệu từ form
        $admin = new Admin();   // tạo đối tượng mới

        $check_admin_user = Admin::where('AdminUser', $data['AdminUser'])->first();//kiểm tra trùng tên

        if($check_admin_user){
            return redirect()->back()->with('error', 'Tài khoản nhân viên này đã tồn tại');
        }else{  // lưu thông tin nhân viên mới
            $admin->AdminName = $data['AdminName'];
            $admin->AdminUser = $data['AdminUser'];
            $admin->AdminPass = md5($data['AdminPass']);
            $admin->Position = $data['Position'];
            $admin->Address = $data['Address'];
            $admin->NumberPhone = $data['NumberPhone'];
            $admin->Email = $data['Email'];
            $admin->save();
            return redirect()->back()->with('message', 'Thêm nhân viên thành công');
        }
    }

    // Xóa nhân viên
    public function delete_staff($idAdmin){
        $admin = Admin::find($idAdmin); // tìm nhân viên theo id

        if($admin->Position === 'Quản Lý'){ // nếu nhân viên có chức vụ quản lý, không thể xóa được
            return redirect()->back()->with('error', 'Không thể xóa tài khoản quản lý');
        }else{// ngược lại
            Admin::find($idAdmin)->delete();
            return redirect()->back();
        }
    }

    // Xóa tài khoản khách hàng
    public function delete_customer($idCustomer){
        Customer::find($idCustomer)->delete();
        return redirect()->back();
    }

    // Thống kê doanh thu theo ngày đã chọn
    public function statistic_by_date(Request $request){
        $data = $request->all();    // lấy dữ liệu từ form

        $DateFrom = $data['DateFrom']; // chọn ngày
        $DateTo = $data['DateTo']; // đến ngày
                                    
        $get_statistic = Bill::whereNotIn('bill.Status',[99])// Loại bỏ đơn đã bị hủy
        ->whereBetween('created_at',[$DateFrom,$DateTo])// Lọc theo ngày
            ->selectRaw('sum(TotalBill) as Sale, count(idBill) as QtyBill, date(created_at) as Date')// Tính tổng tiền và số đơn
            ->groupBy('Date')->get();// Gom theo ngày         
        $total_sold = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')// Lấy chi tiết từng đơn
        ->whereNotIn('bill.Status',[99])// Bỏ đơn hủy
            ->whereBetween('bill.created_at',[$DateFrom,$DateTo]) // Lọc theo ngày
            ->selectRaw('sum(QuantityBuy) as TotalSold, date(bill.created_at) as Date')// Tính tổng sản phẩm
            ->groupBy('Date')->get();

        if($get_statistic->count() > 0){    //kiểm tra dữ liệu có trống hay ko
            foreach($get_statistic as $key => $statistic) // vòng lặp duyệt từng ngày
            {   // tạo phần tử dữ liệu cho biểu đồ
                $chart_data[] = array(
                    'Date' => $statistic->Date, //ngày thống kê
                    'Sale' => $statistic->Sale, //tổng doanh thu trong ngày
                    'TotalSold' => $total_sold[$key]->TotalSold,//tổng số lượng bán ra ngày đó
                    'QtyBill' => $statistic->QtyBill// tổng số đơn hàng trong ngày
                );
            }
        }else $chart_data[] = array(); // trường hợp k có dữ liệu
        //Nếu $get_statistic không có bản ghi, thì gán $chart_data là một mảng rỗng, phòng trường hợp trả về JSON mà không lỗi.
        //Chuyển mảng $chart_data thành chuỗi JSON. In ra để trả về kết quả cho front-end hiển thị biểu đồ.
        echo $data = json_encode($chart_data);
    }

    // Thống kê doanh thu 7 ngày qua
    public function chart_7days(){

        $sub7days = Carbon::now()->subDays(7)->toDateString();  // ngày cách 7 ngày hiện tại, lấy hóa đơn 7 ngày trc -> hiện tại
        // doanh thu số đơn mỗi ngày
        $get_statistic = Bill::whereNotIn('bill.Status',[99]) // chỉ lấy hóa đơn chưa bị hủy
        ->whereBetween('created_at',[$sub7days,now()]) // lọc theo thời gian
            //dữ liệu trả: tổng doanh thu, số lượng đơn , ngày
            ->selectRaw('sum(TotalBill) as Sale, count(idBill) as QtyBill, date(created_at) as Date')
            ->groupBy('Date')->get(); // lọc nhóm theo ngày
        //số lượng sp bán mỗi ngày
        $total_sold = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
            ->whereBetween('bill.created_at',[$sub7days,now()])->selectRaw('sum(QuantityBuy) as TotalSold, date(bill.created_at) as Date')
            ->groupBy('Date')->get();

        if($get_statistic->count() > 0){//kiểm tra dữ liệu có trống hay ko
            foreach($get_statistic as $key => $statistic)// vòng lặp duyệt từng ngày
            {// tạo phần tử dữ liệu cho biểu đồ
                $chart_data[] = array(
                    'Date' => $statistic->Date,//ngày thống kê
                    'Sale' => $statistic->Sale,//tổng doanh thu trong ngày
                    'TotalSold' => $total_sold[$key]->TotalSold,//tổng số lượng bán ra ngày đó
                    'QtyBill' => $statistic->QtyBill// tổng số đơn hàng trong ngày
                );
            }
        }else $chart_data[] = array();// trường hợp k có dữ liệu
        //Nếu $get_statistic không có bản ghi, thì gán $chart_data là một mảng rỗng, phòng trường hợp trả về JSON mà không lỗi.
        //Chuyển mảng $chart_data thành chuỗi JSON. In ra để trả về kết quả cho front-end hiển thị biểu đồ.
        echo $data = json_encode($chart_data);
    }

    // Thống kê doanh thu theo ngày, tháng, năm
    public function statistic_by_date_order(Request $request){
        $data = $request->all();
        // tạo các mốc ngày tương ứng với: 7 ngày trước - 30 ngày trước - 365 ngày trước
        $sub7days = Carbon::now()->subDays(7)->toDateString();
        $sub30days = Carbon::now()->subDays(30)->toDateString();
        $sub365days = Carbon::now()->subDays(365)->toDateString();

        if($data['Days'] == 'lastweek'){ // chọn 7 ngày gần nhất
            $get_statistic = Bill::whereNotIn('bill.Status',[99])// hóa đơn không bị hủy
            ->whereBetween('created_at',[$sub7days,now()])// lọc theo ngày
                ->selectRaw('sum(TotalBill) as Sale, count(idBill) as QtyBill, date(created_at) as Date')// tính tổng doanh thu, số lượng hóa đơn và ngà
                ->groupBy('Date')->get();
            $total_sold = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
                ->whereBetween('bill.created_at',[$sub7days,now()])->selectRaw('sum(QuantityBuy) as TotalSold, date(bill.created_at) as Date')
                ->groupBy('Date')->get();
        }
        else if($data['Days'] == 'lastmonth'){ // chọn 30 ngày gần nhất
            $get_statistic = Bill::whereNotIn('bill.Status',[99])->whereBetween('created_at',[$sub30days,now()])
                ->selectRaw('sum(TotalBill) as Sale, count(idBill) as QtyBill, date(created_at) as Date')
                ->groupBy('Date')->get();
            $total_sold = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
                ->whereBetween('bill.created_at',[$sub30days,now()])->selectRaw('sum(QuantityBuy) as TotalSold, date(bill.created_at) as Date')
                ->groupBy('Date')->get();
        }
        else if($data['Days'] == 'lastyear'){   // chọn 365 ngày
            $get_statistic = Bill::whereNotIn('bill.Status',[99])->whereBetween('created_at',[$sub365days,now()])
                ->selectRaw('sum(TotalBill) as Sale, count(idBill) as QtyBill, date(created_at) as Date')
                ->groupBy('Date')->get();
            $total_sold = BillInfo::join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
                ->whereBetween('bill.created_at',[$sub365days,now()])->selectRaw('sum(QuantityBuy) as TotalSold, date(bill.created_at) as Date')
                ->groupBy('Date')->get();
        }

        if($get_statistic->count() > 0){
            foreach($get_statistic as $key => $statistic)
            {
                $chart_data[] = array(
                    'Date' => $statistic->Date,
                    'Sale' => $statistic->Sale,
                    'TotalSold' => $total_sold[$key]->TotalSold,
                    'QtyBill' => $statistic->QtyBill
                );
            }
        }else $chart_data[] = array();

        echo $data = json_encode($chart_data);
    }

    // Thống kê top sản phẩm bán chạy trong tuần, tháng, năm
    public function topPro_sort_by_date(Request $request){
        $data = $request->all();
        $output = '';
        //Sử dụng Carbon để lấy các mốc thời gian đầu tuần, tháng, năm hiện tại:
        $start_this_week = Carbon::now()->startOfWeek()->toDateString();
        $start_this_month = Carbon::now()->startOfMonth()->toDateString();
        $start_this_year = Carbon::now()->startOfYear()->toDateString();

        if($data['sort_by'] == 'week')      
            $list_topProduct = Product::join('productimage','productimage.idProduct','=','product.idProduct')// join vào các bảng
            ->join('billinfo','billinfo.idProduct','=','product.idProduct')
            ->join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])// loại bỏ đơn hủy
            ->whereBetween('bill.created_at', [$start_this_week,now()])//lọc theo khoảng thời gian, ngày tạo hóa đơn, nhóm theo tên sp và ảnh
            ->select('ProductName','ImageName')
            ->selectRaw('sum(QuantityBuy) as Sold')//tính tổng số lượng bán
            ->groupBy('ProductName','ImageName')->orderBy('Sold','DESC')->take(6)->get();// lấy tối đa 6 sp, 
        else if($data['sort_by'] == 'month')
            $list_topProduct = Product::join('productimage','productimage.idProduct','=','product.idProduct')
            ->join('billinfo','billinfo.idProduct','=','product.idProduct')
            ->join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
            ->whereBetween('bill.created_at', [$start_this_month,now()])
            ->select('ProductName','ImageName')
            ->selectRaw('sum(QuantityBuy) as Sold')
            ->groupBy('ProductName','ImageName')->orderBy('Sold','DESC')->take(6)->get();
        else if($data['sort_by'] == 'year')
            $list_topProduct = Product::join('productimage','productimage.idProduct','=','product.idProduct')
            ->join('billinfo','billinfo.idProduct','=','product.idProduct')
            ->join('bill','bill.idBill','=','billinfo.idBill')->whereNotIn('bill.Status',[99])
            ->whereBetween('bill.created_at', [$start_this_year,now()])
            ->select('ProductName','ImageName')
            ->selectRaw('sum(QuantityBuy) as Sold')
            ->groupBy('ProductName','ImageName')->orderBy('Sold','DESC')->take(6)->get();
        //Trả về đoạn HTML <ul> chứa các thẻ <li> hiển thị hình ảnh + tên + số lượng đã bán.
        $output .= '<ul class="list-unstyled row mb-0">';
        foreach($list_topProduct as $key => $topProduct){
            $image = json_decode($topProduct->ImageName)[0];
            $output .= '
                <li class="col-lg-4 topPro-item">
                    <div class="card card-block card-stretch mb-0">
                        <div class="card-body">
                            <div class="bg-warning-light rounded">
                                <img src="public/storage/kidoldash/images/product/'.$image.'" class="style-img img-fluid m-auto p-3" alt="image">
                            </div>
                            <div class="style-text text-left mt-3">
                                <h5 class="mb-1 limit-2-lines">'.$topProduct->ProductName.'</h5>
                                <p class="mb-0">Đã bán: '.number_format($topProduct->Sold,0,',','.').'</p>
                            </div>
                        </div>
                    </div>
                </li>
            ';
        }
        $output .= '</ul>';

        echo $output;
    }
}
