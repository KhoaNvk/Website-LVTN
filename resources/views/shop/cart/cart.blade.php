@extends('shop_layout')
@section('content')

    <!--Page Banner Start-->
    <div class="page-banner" style="background-image: url(public/kidolshop/images/banner/ch.jpg);">
        <div class="container">
            <div class="page-banner-content text-center">
                <h2 class="title">Giỏ Hàng</h2>
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ Hàng</li>
                </ol>
            </div>
        </div>
    </div>
    <!--Page Banner End-->

    <form id="form-payment">
        @csrf
        <!--Cart Start-->
        <div class="cart-page section-padding-5">
            <div class="container">
                <div class="cart-btn">
                    <div class="cart-btn-left">
                        <a href="{{URL::to('/store')}}" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>
                    <div class="cart-btn-right">
                        <a href="{{URL::to('/delete-cart')}}" class="btn">Xóa giỏ hàng</a>
                    </div>
                </div>
                </br>
                <div class="cart-table table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="image">Hình Ảnh</th>
                            <th class="product">Sản Phẩm</th>
                            <th class="price">Giá</th>
                            <th class="quantity">Số Lượng</th>
                            <th class="total">Tổng</th>
                            <th class="remove">Xóa</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $Total = 0; ?>
                        @foreach($list_pd_cart as $key => $pd_cart)
                                <?php $Total += ($pd_cart->PriceNew * $pd_cart->QuantityBuy); ?>
                            <tr class="product-item">
                                    <?php $image = json_decode($pd_cart->ImageName)[0]; ?>
                                <td class="image">
                                    <a href="{{URL::to('/shop-single/'.$pd_cart->ProductSlug)}}"><img
                                            src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                            alt=""></a>
                                </td>
                                <td class="product">
                                    <a href="{{URL::to('/shop-single/'.$pd_cart->ProductSlug)}}">{{$pd_cart->ProductName}}</a>
                                    <span>Mã sản phẩm: {{$pd_cart->idProduct}}</span>
                                    <div class="list-option mt-2 ">
                                        @foreach($pd_cart->attribute as $item)
                                            <div class="d-flex align-items-center justify-content-start" style="gap: 10px;">
                                                <p class="mb-0">{{ $item['attribute']->AttributeName }}: </p>
                                                <p class="mb-0">{{ $item['property']->AttrValName }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="text-primary">Còn Lại: {{$pd_cart->Quantity}}</span>
                                        <?php $replace = [" ", ":"]; ?>
                                    <input type="hidden" class="Quantity"
                                           id="<?php echo 'Quantity-'.$pd_cart->idProduct.'-'.str_replace($replace,"",$pd_cart->AttributeProduct);?>"
                                           value="{{$pd_cart->Quantity}}">
                                </td>
                                <td class="price">
                                    <span class="amount">{{number_format($pd_cart->PriceNew,0,',','.')}}đ</span>
                                </td>
                                <td class="quantity">
                                    <div class="quantity d-inline-flex">
                                        <button type="button" class="sub-qty"
                                                id="sub-qty-{{$pd_cart->idProduct}}-{{$pd_cart->AttributeProduct}}"><i
                                                class="ti-minus"></i></button>
                                        <input type="number" class="QuantityBuy"
                                               id="QuantityBuy-{{$pd_cart->idProduct}}"
                                               value="{{$pd_cart->QuantityBuy}}" min="1"
                                               oninput="validity.valid||(value='1');"/>
                                        <button type="button" class="add-qty"
                                                id="{{$pd_cart->idProduct}}-{{$pd_cart->AttributeProduct}}"><i
                                                class="ti-plus"></i></button>
                                        <div class="alert-qty-input"><span class="message-qty-input">Mua tối đa {{$pd_cart->Quantity}} sản phẩm!</span>
                                        </div>
                                        <input type="hidden" value="{{$pd_cart->idCart}}">
                                        <input type="hidden" value="{{$pd_cart->PriceNew}}">
                                        <input type="hidden" value="{{$pd_cart->Quantity}}">
                                    </div>
                                </td>
                                <td class="total">
                                    <span class="total-amount">{{number_format($pd_cart->Total,0,',','.')}}đ</span>
                                </td>
                                <td class="remove">
                                    <a class="view-hover delete-pd-cart"
                                       href="{{ url('/delete-pd-cart/' . $pd_cart->idCart) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-totals">
                            <div class="container__address-content-hd">
                                <i class="container__address-content-hd-icon fa fa-shopping-cart"></i>
                                <div>Tổng giỏ hàng</div>
                            </div>
                            <div class="cart-total-table mt-25">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="value">Thành Tiền</h2>
                                        </td>
                                        <td>
                                            <p class="price"
                                               style="color: red; float: right;">{{number_format($Total,0,',','.')}}
                                                đ</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-totals">
                            <div class="cart-total-btn">
                                <a href="{{URL::to('/payment')}}" class="btn btn-primary btn-block btn-payment">Thanh
                                    toán</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 mt-30 h2" style="color:#222;">CÓ THỂ BẠN SẼ THÍCH</div>
                    <div class="col-lg-12">
                        <?php $id_pds = json_decode($recommend_pds) ?>
                        <div class="row">
                            @foreach($id_pds as $key => $id_pd)
                                    <?php $product = App\Http\Controllers\CartController::get_product($id_pd); ?>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="single-product">
                                        <div class="product-image">
                                                <?php $image = json_decode($product->ImageName)[0]; ?>
                                            <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">
                                                <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                                     alt="">
                                            </a>

                                                <?php
                                                $SalePrice = $product->Price;
                                                $get_time_sale = App\Http\Controllers\ProductController::get_sale_pd($product->idProduct);
                                                ?>

                                            @if($get_time_sale)
                                                    <?php $SalePrice = $product->Price - ($product->Price / 100) * $get_time_sale->Percent; ?>
                                                <div class="product-countdown">
                                                    <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                                </div>
                                                @if($product->QuantityTotal == '0')
                                                    <span class="sticker-new soldout-title">Hết hàng</span>
                                                @else
                                                    <span
                                                        class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                                @endif
                                            @elseif($product->QuantityTotal == '0')
                                                <span class="sticker-new soldout-title">Hết hàng</span>;
                                            @endif

                                            <div class="action-links">
                                                <ul>
                                                    <li><a class="add-to-compare" data-idcat="{{$product->idCategory}}"
                                                           id="{{$product->idProduct}}" data-tooltip="tooltip"
                                                           data-placement="left" title="So sánh"><i
                                                                class="icon-sliders"></i></a></li>
                                                    <li><a class="add-to-wishlist" data-id="{{$product->idProduct}}"
                                                           data-tooltip="tooltip" data-placement="left"
                                                           title="Thêm vào danh sách yêu thích"><i
                                                                class="icon-heart"></i></a></li>
                                                    <li><a class="quick-view-pd" data-id="{{$product->idProduct}}"
                                                           data-tooltip="tooltip" data-placement="left"
                                                           title="Xem nhanh"><i class="icon-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-content text-center">
                                            <h4 class="product-name"><a
                                                    href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">{{$product->ProductName}}</a>
                                            </h4>
                                            <div class="price-box">
                                                @if($SalePrice < $product->Price)
                                                    <span class="old-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                                    <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                                @else
                                                    <span class="current-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Cart End-->
    </form>

    <script>
        $(document).ready(function () {
            // Cập nhật giỏ hàng khi click xóa 1 sản phẩm
            $('.delete-pd-cart').on('click', function (e) {
                e.preventDefault(); //ngắn ko cho chuyển trang khi ấn click
                var $this = $(this);
                var url = $this.attr('href');   //lấy dường dẫn url từ thuộc tính href của nút được click

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}", //gửi yêu cầu đến sv để xóa sp, gửi kèm mã csrf(bảo mật của laravel)
                    },
                    success: function (response) {
                        if (response.success) { //nếu thành công thì sẽ xóa sản phẩm đó 
                            $this.closest('.product-item').remove();
                            // Kiểm tra số lượng sản phẩm trong giỏ hàng
                            if ($('.product-item').length === 0) {  // nếu ko còn sản phẩm, chuyển đến trang giỏ hàng trống
                                window.location.href = '../kidolshop/empty-cart';
                            } else {    //nếu còn sp
                                location.reload(); // Tải lại trang giỏ hàng
                            }
                        } else {    // xuất tb lỗi nếu ko thể gửi yêu cầu,hoặc sv lỗi
                            console.error('Error: Could not delete the product.');
                        }
                    },
                    error: function () {
                        console.error('Error: Could not complete the request.');
                    }
                });
            });
            // Cập nhật số lượng khi click "+"
            $('.add-qty').on('click', function () {
                var id = $(this).attr("id");    // lấy id sản phẩm từ id của nút được click
                var id_replace = id.replace(/ /g, "").replace(/:/g, "");
                //Quantity là tổng số lượng sp đó đang có cho mỗi size mỗi màu, currentvalue là soluong ngdung đang mua
                var Quantity = parseInt($('#Quantity-' + id_replace).val());
                var $input = $(this).prev();
                var currentValue = parseInt($input.val());
                if (currentValue >= Quantity) { // nếu ng mua cố gắng mua hơn số lượng sp đang có
                    $alert_element = $(this).next();
                                                    // sẽ hiển thông báo lỗi vượt quá số lượng cần mua
                    $alert_element.css({'transform': 'scale(1)', 'opacity': '1'});  // hiện cảnh báo và ẩn đi 1 giây
                    setTimeout(function () {
                        $alert_element.css({'transform': 'scale(0)', 'opacity': '0'});
                    }, 1000);
                } else {    // ngược lại
                    $input.val(currentValue + 1);   // tăng số lượng sp lên 1 nếu chưa vượt qua số lượng còn lại sp
                    // lưu các thông tin để cập nhật giỏ hàng: id, giá, số lượng, token bảo mật
                    var idCart = $(this).nextAll().eq(1).val();
                    var PriceNew = $(this).nextAll().eq(2).val();
                    var Quantity = $(this).nextAll().eq(3).val();
                    var _token = $('input[name="_token"]').val();
                    //Gửi POST để cập nhật lại giỏ hàng trên server rồi reload trang để hiển thị kết quả.
                    $.ajax({
                        url: '{{url("/update-qty-cart")}}',
                        method: 'POST',
                        data: {
                            idCart: idCart,
                            QuantityBuy: $input.val(),
                            PriceNew: PriceNew,
                            Quantity: Quantity,
                            _token: _token
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            });

            // Cập nhật số lượng khi click "-"
            $('.sub-qty').on('click', function () {
                var $input = $(this).next();    // lấy ô input số lượng hiện tại
                var currentValue = parseInt($input.val());
                // nếu số lượng hiện tại lơn hơn 1 thì giảm đi 1
                if (currentValue > 1) {
                    $input.val(currentValue - 1);
                    // lấy thông tin để cập nhật giỏ hàng
                    var idCart = $(this).nextAll().eq(3).val();
                    var PriceNew = $(this).nextAll().eq(4).val();
                    var Quantity = $(this).nextAll().eq(5).val();
                    var _token = $('input[name="_token"]').val();
                // gửi request cập nhật số lượng 
                    $.ajax({
                        url: '{{url("/update-qty-cart")}}',
                        method: 'POST',
                        data: {
                            idCart: idCart,
                            QuantityBuy: $input.val(),
                            PriceNew: PriceNew,
                            Quantity: Quantity,
                            _token: _token
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }

                $(this).nextAll().eq(2).css({'transform': 'scale(0)', 'opacity': '0'});
            });

            // Cập nhật QuantityBuy khi sửa số lượng trong input
            $("input[type='number']").bind("focus", function () {
                var value = parseInt($(this).val());    // nhập vào ô nhập số lượng, lưu giá trị ban đầu
                // kiểm tra giá trị đó hợp lệ không
                $(this).bind("blur", function () {
                    var id = $(this).next().attr("id");
                    var id_replace = id.replace(/ /g, "").replace(/:/g, "");
                    var Quantity = parseInt($('#Quantity-' + id_replace).val());
                    // nếu số lượng mới ko vượt qua số lượng còn lại của sp => cập nhật giỏ hàng
                    if (value != parseInt($(this).val()) && Quantity >= $(this).val()) {
                        var idCart = $(this).nextAll().eq(2).val();
                        var PriceNew = $(this).nextAll().eq(3).val();
                        var Quantity = $(this).nextAll().eq(4).val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url("/update-qty-cart")}}',
                            method: 'POST',
                            data: {
                                idCart: idCart,
                                QuantityBuy: $(this).val(),
                                PriceNew: PriceNew,
                                Quantity: Quantity,
                                _token: _token
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    } else {    // nếu nhập sai sẽ hiện cảnh báo và không gửi request
                        $(this).unbind("blur");
                        $(this).nextAll().eq(1).css({'transform': 'scale(1)', 'opacity': '1'});
                        setTimeout(function () {
                            $(".alert-qty-input").css({'transform': 'scale(0)', 'opacity': '0'});
                        }, 3000);
                    }
                });
            });

            // Kiểm tra QuantityBuy khi click thanh toán
            $('.btn-payment').on('click', function (e) {
                $("#form-payment .product-item").each(function () {
                    // kiểm tra số lượng mua với mỗi sản phẩm trong thanh toán
                    var Quantity = parseInt($(".Quantity", this).val());
                    var QuantityBuy = parseInt($(".QuantityBuy", this).val());
                    // nếu chưa nhập số lượng hoặc nhập sai=> cảnh báo yêu cầu nhâp đúng số
                    if (isNaN(QuantityBuy) || QuantityBuy <= 0) {
                        $(".alert-qty-input .message-qty-input", this).text("Vui lòng nhập đúng số lượng cần mua");
                        $(".alert-qty-input", this).css({'transform': 'scale(1)', 'opacity': '1'});
                        setTimeout(function () {
                            $(".alert-qty-input").css({'transform': 'scale(0)', 'opacity': '0'});
                        }, 3000);
                        $("html, body").animate({scrollTop: ($(".alert-qty-input", this).position().top + 200)}, "fast");
                        e.preventDefault();
                    } else if (QuantityBuy > Quantity) {   // hiển thị cảnh báo giới hạn, ko cho thanh toán
                        $(".alert-qty-input .message-qty-input", this).text("Mua tối đa " + Quantity + " sản phẩm!");
                        $(".alert-qty-input", this).css({'transform': 'scale(1)', 'opacity': '1'});
                        setTimeout(function () {
                            $(".alert-qty-input").css({'transform': 'scale(0)', 'opacity': '0'});
                        }, 3000);
                        $("html, body").animate({scrollTop: ($(".alert-qty-input", this).position().top + 200)}, "fast");
                        e.preventDefault();
                    }
                });
            });

        });
    </script>

@endsection
