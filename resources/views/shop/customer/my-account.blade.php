@extends('shop_layout')
@section('content')

<!--Page Banner Start-->
<div class="page-banner" style="background-image: url(public/kidolshop/images/acc.jpg);">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Tài khoản của tôi</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tài khoản của tôi</li>
            </ol>
        </div>
    </div>
</div>
<!--Page Banner End-->

<!--My Account Start-->
<div class="register-page section-padding-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4">
                <div class="my-account-menu mt-30">
                    <ul class="nav account-menu-list flex-column">
                        <li>
                            <a class="active"><i class="fa fa-user"></i> Hồ Sơ</a>
                        </li>
                        @if(empty($customer->google_id)) 
                            <!-- Chỉ hiển thị nếu user đăng ký tài khoản bình thường -->
                            <li>
                                <a href="{{URL::to('/change-password')}}"><i class="fa fa-key"></i> Đổi Mật Khẩu</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{URL::to('/ordered')}}"><i class="fa fa-shopping-cart"></i> Đơn Đặt Hàng</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-md-8">
                <div class="tab-content my-account-tab mt-30" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-account">
                        <div class="tab-content my-account-tab" id="pills-tabContent">
                            <div class="tab-pane fade active show">
                                <div class="my-account-address account-wrapper">
                                    <div class="row">
                                        <div class="col-md-12" style="border-bottom: solid 1px #efefef;">
                                            <h4 class="account-title" style="margin-bottom: 0;">Thông tin</h4>
                                        </div>
                                        <form id="form-edit-profile" style="display:flex; padding: 0;" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-8 mt-10">
                                                <div class="account-address">
                                                    <div class="profile__info-body-left-item">
                                                        <span class="profile__info-body-left-item-title">Tên Đăng Nhập</span>
                                                        <span class="profile__info-body-left-item-text ml-20">{{$customer->username}}</span>
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span for="CustomerName" class="profile__info-body-left-item-title" style="margin: 0 28px 0 52px;">Họ Và Tên</span>
                                                        <input id="CustomerName" name="CustomerName" class="ml-30" style="width:65%;" type="text" value="{{$customer->CustomerName}}">
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title" style="margin-left: 52px;">Số Điện Thoại</span>
                                                        <input class="ml-30" style="width:65%;" name="PhoneNumber" id="PhoneNumber" type="text" value="{{$customer->PhoneNumber}}">
                                                    </div>

                                                    <div class="form-group mb-30">
                                                        <span for="Address" class="profile__info-body-left-item-title" style="margin: 0 58px 0 52px;">Địa chỉ </span>
                                                        <input class="ml-30" style="width:65%;" name="Address" id="Address" type="text" value="{{$customer->Address}}">
                                                        
                                                    </div>
                                                    
                                                    <button class="btn btn-primary edit-profile" style="float: right;"><i class="fa fa-edit"></i> Sửa Hồ Sơ</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-10 d-flex align-items-center justify-content-center" style="border-left: solid 1px #efefef; margin: 0 12px;">
                                                <div class="profile__info-body-right-avatar">
                                                    <div class="profile-img-edit">
                                                        <div class="crm-profile-img-edit">
                                                            @if(!empty($customer->Avatar) && Str::startsWith($customer->Avatar, 'http'))
                                                                <!-- Avatar từ Google -->
                                                                <img class="crm-profile-pic rounded-circle avatar-100 replace-avt" src="{{ $customer->Avatar }}" alt="Google Avatar">
                                                            @elseif(!empty($customer->Avatar))
                                                                <!-- Avatar từ hệ thống -->
                                                                <img class="crm-profile-pic rounded-circle avatar-100 replace-avt" src="{{ asset('public/storage/kidoldash/images/customer/'.$customer->Avatar) }}" alt="Local Avatar">
                                                                
                                                                <!-- Chỉ hiện nút đổi avatar nếu KHÔNG phải tài khoản Google -->
                                                                <div class="crm-p-image bg-primary">
                                                                    <label for="Avatar" style="cursor:pointer;"><span class="ti-pencil upload-button d-block"></span></label>
                                                                    <input type="file" class="file-upload" id="Avatar" name="Avatar" onchange="loadPreview(this)" accept="image/*">
                                                                </div>
                                                            @else
                                                                <!-- Avatar mặc định nếu user chưa đặt avatar -->
                                                                <img class="crm-profile-pic rounded-circle avatar-100 replace-avt" src="{{ asset('public/kidoldash/images/user/1.png') }}" alt="Default Avatar">
                                                                
                                                                <!-- Hiện nút đổi avatar nếu user chưa có avatar nhưng KHÔNG phải tài khoản Google -->
                                                                <div class="crm-p-image bg-primary">
                                                                    <label for="Avatar" style="cursor:pointer;"><span class="ti-pencil upload-button d-block"></span></label>
                                                                    <input type="file" class="file-upload" id="Avatar" name="Avatar" onchange="loadPreview(this)" accept="image/*">
                                                                </div>
                                                            @endif
                                                        </div>                                          
                                                    </div>

                                                    <div class="text-danger alert-img mt-3 ml-3 mr-3"></div>

                                                    <div class="mt-30">
                                                        <span class="profile__info-body-right-avatar-condition-item">Dung lượng file tối đa 2MB</span>
                                                        <span class="profile__info-body-right-avatar-condition-item">Định dạng: .JPEG, .PNG</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--My Account End-->

<script src="{{asset('public/kidolshop/js/jquery.validate.min.js')}}"></script>

<script>
    // CẬP NHẬT THÔNG TIN TÀI KHOẢN CÁ NHÂN
    window.scrollBy(0, 300);

    $(document).ready(function(){  
        $('.edit-profile').on('click', function(){
            $("#form-edit-profile").validate({
                rules: {
                    CustomerName: {
                        required: true,
                        minlength: 5
                    },
                    PhoneNumber: {
                        required: true,
                        minlength: 10,
                        maxlength: 12
                    },
                    Address: {
                        required: true
                    }
                },

                messages: {
                    CustomerName: {
                        required: "Vui lòng nhập trường này",
                        minlength: "Nhập họ và tên tối thiểu 5 ký tự"
                    },
                    PhoneNumber: {
                        required: "Vui lòng nhập trường này",
                        minlength: "Nhập số điện thoại tối thiểu 10 chữ số",
                        maxlength: "Nhập số điện thoại tối đa 12 chữ số"
                    },
                    Address: {
                        required: "Vui lòng nhập trường này"
                    }
                },
                // nếu form hợp lệ gửi 
                submitHandler: function(form) { 
                    //FormData là object giúp gửi cả dữ liệu text và file.
                    let formData = new FormData($('#form-edit-profile')[0]);
                    if ($('input[type=file]')[0].files[0]) {    // nếu có ảnh dc chọn, thêm vào form data gửi lên sv
                        let file = $('input[type=file]')[0].files[0];
                        formData.append('file', file, file.name);
                    }
                    //AJAX POST CẬP NHẬT THÔNG TIN 
                    $.ajax({
                        url: APP_URL + '/edit-profile',
                        type: 'POST',   
                        contentType: false,
                        processData: false,   
                        cache: false,        
                        data: formData,
                        success: function(data) {   // xử lý thành công 
                            Swal.fire({ // hiện thông báo SweetAlert
                                title: 'Cập nhật tài khoản thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();//  sau khi ấn ok thì reload lại trang
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({ // hiện thông báo SweetAlert
                                title: 'Cập nhật thất bại',
                                text: 'Đã xảy ra lỗi khi cập nhật tài khoản. Vui lòng thử lại sau.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
    // CẬP NHẬT AVATAR
    //Khi người dùng chọn ảnh từ máy, ảnh sẽ được hiển thị ngay trên giao diện (xem trước).
    function loadPreview(input) {
        // duyệt qua các file ( chỉ chọn 1)
        var data = $(input)[0].files; 
        $.each(data, function(index, file){

            //Nếu là ảnh hợp lệ (định dạng và size nhỏ hơn 2MB):
            if(/(\.|\/)(gif|jpeg|png|jpg|svg)$/i.test(file.type) && file.size < 2000000 ){
                //Hiển thị ảnh xem trước:
                //Đọc nội dung file ảnh thành URL base64 và gán vào src của ảnh có class .replace-avt
                //
                var fRead = new FileReader();
                fRead.onload = (function(file){
                    return function(e) {
                        $('.replace-avt').attr('src', e.target.result);
                    };
                })(file);
                fRead.readAsDataURL(file);
                //Đồng thời hiển thị tên file ảnh:  
                $('.alert-img').html($('#Avatar').val().replace(/^.*[\\\/]/, ''));
            } else {    // nếu file không hợp lệ
                document.querySelector('#Avatar').value = '';   // xóa ảnh đã chọn và hiện thông báo
                $('.alert-img').html("Tệp hình ảnh phải có định dạng .gif, .jpeg, .png, .jpg, .svg dưới 2MB");
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        //Lấy tỉnh thành
        $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm',function(data_tinh){	       
            if(data_tinh.error==0){
               $.each(data_tinh.data, function (key_tinh,val_tinh) {
                  $("#tinh").append('<option value="'+val_tinh.id+'">'+val_tinh.full_name+'</option>');
               });
               $("#tinh").change(function(e){
                    var idtinh=$(this).val();
                    //Lấy quận huyện
                    $.getJSON('https://esgoo.net/api-tinhthanh/2/'+idtinh+'.htm',function(data_quan){	       
                        if(data_quan.error==0){
                           $("#quan").html('<option value="0">Quận Huyện</option>');  
                           $("#phuong").html('<option value="0">Phường Xã</option>');   
                           $.each(data_quan.data, function (key_quan,val_quan) {
                              $("#quan").append('<option value="'+val_quan.id+'">'+val_quan.full_name+'</option>');
                           });
                           //Lấy phường xã  
                           $("#quan").change(function(e){
                                var idquan=$(this).val();
                                $.getJSON('https://esgoo.net/api-tinhthanh/3/'+idquan+'.htm',function(data_phuong){	       
                                    if(data_phuong.error==0){
                                       $("#phuong").html('<option value="0">Phường Xã</option>');   
                                       $.each(data_phuong.data, function (key_phuong,val_phuong) {
                                          $("#phuong").append('<option value="'+val_phuong.id+'">'+val_phuong.full_name+'</option>');
                                       });
                                    }
                                });
                           });
                            
                        }
                    });
               });   
                
            }
        });
     });	    
 </script>

@endsection