@extends('shop_layout')
@section('content')

<!--Page Banner Start-->
<div class="page-banner" style="background-image: url(public/kidolshop/images/acc.jpg);">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Đổi mật khẩu</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
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
                            <a href="{{URL::to('/account')}}"><i class="fa fa-user"></i> Hồ Sơ</a>
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
                        <li>
                            <a href="{{URL::to('/show-voucher')}}"><i class="fa fa-ticket"></i> Kho voucher</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-md-8">
                <div class="tab-content my-account-tab mt-30" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-password">
                        <div class="my-account-address account-wrapper">
                            <div class="row">
                                <div class="col-md-12" style="border-bottom: solid 1px #efefef;">
                                    <h4 class="account-title" style="margin-bottom: 0;">Đổi Mật Khẩu</h4>
                                </div>
                                <form id="form-change-password">
                                    @csrf
                                    <div class="text-primary mt-2 alert-password"></div>
                                    <div class="col-md-12">
                                        <div class="account-address mt-30">
                                            <div class="form-group mb-30">
                                                <div class="input-group">
                                                    <input name="password" id="password" type="password" style="width: 170%" placeholder="Mật Khẩu Cũ">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                                            <i class="fa fa-eye" id="eye-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-30">
                                                <div class="input-group">
                                                    <input name="newpassword" id="newpassword" type="password" style="width: 170%" placeholder="Mật Khẩu Mới">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="toggle-newpassword">
                                                            <i class="fa fa-eye" id="eye-icon-newpassword"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-30">
                                                <div class="input-group">
                                                    <input name="renewpassword" id="renewpassword" type="password" style="width: 170%" placeholder="Nhập Lại Mật Khẩu">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="toggle-renewpassword">
                                                            <i class="fa fa-eye" id="eye-icon-renewpassword"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="btn btn-primary change-password" type="submit" style="float: right;" value="Lưu">
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
<!--My Account End-->
<style>
    .input-group {
        position: relative;
    }

    #password {
        padding-right: 140px; 
    }

    #toggle-password {
        position: absolute;
        right: 10px; 
        top: 10%;
        transform: translateY(-50%);
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }

    #toggle-newpassword {
        position: absolute;
        right: 10px; 
        top: 10%;
        transform: translateY(-50%);
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }

    #toggle-renewpassword {
        position: absolute;
        right: 10px; 
        top: 10%;
        transform: translateY(-50%);
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }
</style>
<script src="{{asset('public/kidolshop/js/jquery.validate.min.js')}}"></script>

<!-- Thêm thư viện validate nếu chưa có -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script> -->

<script>
    $(document).ready(function () {
        // Cuộn xuống 300px khi load
        window.scrollBy(0, 300);

        // /^(?=.*[A-Z])(?=.*\d).{8,} : 8 ký tự, 1 chữ hoa và 1 số
        // *[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,} /; 8 ký tự, và có 1 ký tự đặc biệt
         //Thêm rule kiểm tra mật khẩu mạnh
        $.validator.addMethod("strongPassword", function (value, element) {
            return this.optional(element) || /^.{8,}$/.test(value);
        }, "Mật khẩu phải ít nhất 8 ký tự");

        // Validate form
        $("#form-change-password").validate({
            rules: {
                password: {
                    required: true,
                    strongPassword: true
                },
                newpassword: {
                    required: true,
                    strongPassword: true
                },
                renewpassword: {
                    required: true,
                    equalTo: "#newpassword"
                }
            },
            messages: {
                password: {
                    required: "Vui lòng nhập mật khẩu hiện tại"
                },
                newpassword: {
                    required: "Vui lòng nhập mật khẩu mới"
                },
                renewpassword: {
                    required: "Vui lòng xác nhận lại mật khẩu mới",
                    equalTo: "Mật khẩu xác nhận không khớp"
                }
            },
            submitHandler: function (form) {
                let formData = new FormData(form);
                $.ajax({
                    url: APP_URL + '/submit-change-password',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        Swal.fire({
                            title: 'Thay đổi mật khẩu thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Thay đổi mật khẩu thất bại',
                            text: 'Vui lòng thử lại',
                            icon: 'error'
                        });
                    }
                });
            }
        });
        
         //Hàm toggle hiển thị/ẩn mật khẩu
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Gắn sự kiện toggle
        $("#toggle-password").click(() => togglePassword("password", "eye-icon"));
        $("#toggle-newpassword").click(() => togglePassword("newpassword", "eye-icon-newpassword"));
        $("#toggle-renewpassword").click(() => togglePassword("renewpassword", "eye-icon-renewpassword"));
    });
</script>



@endsection