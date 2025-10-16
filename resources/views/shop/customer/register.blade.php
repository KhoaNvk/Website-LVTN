@extends('shop_layout')
@section('content')

<?php use Illuminate\Support\Facades\Session; ?>

<!--Page Banner Start-->
<div class="page-banner">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Đăng Ký</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đăng Ký</li>
            </ol>
        </div>
    </div>
</div>
<!--Page Banner End-->

<!--Register Start-->
<div class="register-page section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-register-content">
                    <h4 class="title">Tạo Tài Khoản Mới</h4>

                    <div class="login-register-form">
                        <form method="POST" action="{{URL::to('/submit-register')}}" id="form-register">
                            @csrf
                            <div class="form-group mt-15">
                                <label for="username">Tên tài khoản</label>
                                <input id="username" type="text" name="username">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mt-15">
                                <label for="password">Mật khẩu</label>
                                <div class="input-group">
                                    <input id="password" type="password" name="password" class="form-control">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                            <i class="fa fa-eye" id="eye-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mt-15">
                                <label for="repassword">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <input id="repassword" type="password" name="repassword" class="form-control">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="toggle-repassword">
                                            <i class="fa fa-eye" id="eye-icon-repassword"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mt-15">
                                <input type="submit" class="btn btn-primary btn-block"  value="Đăng ký"/>
                            </div>
                            <div class="form-group mt-15">
                                <label>Bạn đã có tài khoản?</label>
                                <a href="{{URL::to('/login')}}" class="btn btn-dark btn-block">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Register End-->
<style>
    .input-group {
        position: relative;
    }

    #password {
        padding-right: 40px; 
    }

    #toggle-password {
        position: absolute;
        right: 10px; 
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }

    #toggle-repassword {
        position: absolute;
        right: 10px; 
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }
</style>
<!-- Validate form đăng ký -->
<script>
    @if(Session::has('message'))
        Swal.fire({
            title: '{{ Session::get('message') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location = "{{ url('login') }}";
        });
    @endif
</script>
<script>
    $(document).ready(function(){  
        // *[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,} /; 8 ký tự, và có 1 ký tự đặc biệt
       // Hàm kiểm tra mật khẩu: ít nhất 8 ký tự, 1 chữ hoa, 1 số
        // Validator.isPassword = function(selector) {
        //     return {
        //         selector: selector,
        //         test: function(value) {
        //             const passwordRegex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
        //             return passwordRegex.test(value)
        //                 ? undefined
        //                 : "Mật khẩu phải có ít nhất 8 ký tự, chứa ít nhất 1 chữ hoa và 1 chữ số";
        //         }
        //     };
        // }; 

        Validator({
            form: "#form-register",
            errorSelector: ".text-danger",
            parentSelector: ".form-group",
            rules:[
            Validator.isRequired("#username"),  //ràng buộc không được để trống
            Validator.isRequired("#password"),  
            Validator.isRequired("#repassword"),
            //Validator.isPassword("#password"), // Gắn ràng buộc đã cập nhật ở trên
            Validator.isFullname('#username'),  
            Validator.isPassword("#password"),  
            Validator.isRePassword("#repassword",function(){    
                return  document.querySelector("#form-register #password").value;
            })
            ]
        });
        // Ẩn hiện mật khẩu
        $('#toggle-password').click(function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            var eyeIcon = $('#eye-icon');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        // Ẩn hiện nhập lại mật khẩu
        $('#toggle-repassword').click(function() {
            var repasswordField = $('#repassword');
            var repasswordFieldType = repasswordField.attr('type');
            var eyeIconRepassword = $('#eye-icon-repassword');

            if (repasswordFieldType === 'password') {
                repasswordField.attr('type', 'text');
                eyeIconRepassword.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                repasswordField.attr('type', 'password');
                eyeIconRepassword.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>

@endsection