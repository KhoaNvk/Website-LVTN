@extends('shop_layout')
@section('content')

    <!--Page Banner Start-->
    <div class="page-banner" style="background-image: url(../public/kidolshop/images/banner/ch-1.jpg)">
        <div class="container">
            <div class="page-banner-content text-center">
                <h2 class="title">Chi tiết sản phẩm</h2>
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{URL::to('/store')}}">Cửa hàng</a></li>
                    <li class="breadcrumb-item">{{$product->ProductName}}</li>
                </ol>
            </div>
        </div>
    </div>
    <!--Page Banner End-->

    <?php

    use App\Http\Controllers\ProductController;
    use Illuminate\Support\Facades\Session;

    $image = json_decode($product->ImageName)[0];
    $get_time_sale = ProductController::get_sale_pd($product->idProduct);
    $SalePrice = $product->Price;
    if ($get_time_sale) $SalePrice = $product->Price - ($product->Price / 100) * $get_time_sale->Percent;
    ?>

        <!--Shop Single Start-->
    <div class="shop-single-page section-padding-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="shop-image">
                        <div class="shop-single-preview-image">
                            <img class="product-zoom" src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                 alt="">
                            @if($get_time_sale)
                                @if($product->QuantityTotal == '0')
                                    <span class="sticker-new label-sale">HẾT HÀNG</span>
                                @else
                                    <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                @endif
                            @elseif($product->QuantityTotal == '0')
                                <span class="sticker-new label-sale">HẾT HÀNG</span>
                            @endif
                        </div>
                        <div id="gallery_01" class="shop-single-thumb-image shop-thumb-active swiper-container">
                            <div class="swiper-wrapper">
                                @foreach(json_decode($product->ImageName) as $img)
                                    <div class="swiper-slide single-product-thumb">
                                        <a class="active" href="#"
                                           data-image="{{asset('public/storage/kidoldash/images/product/'.$img)}}">
                                            <img src="{{asset('public/storage/kidoldash/images/product/'.$img)}}"
                                                 alt="">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Add Arrows -->
                            <div class="swiper-thumb-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-thumb-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shop-single-content">
                        <h3 class="title">{{$product->ProductName}}</h3>

                        <span class="product-sku">
                        <span class="sku-item">{{$product->Sold}} đã bán</span>
                        <span class="sku-item">{{$count_wish}} yêu thích</span>
                        <span class="sku-item">Mã sản phẩm: {{$product->idProduct}}</span>
                    </span>

                        <div class="thumb-price">
                            @if($SalePrice < $product->Price)
                                <span class="old-price">{{number_format($product->Price,0,',','.')}}đ</span>
                                <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                <span class="discount">-{{$get_time_sale->Percent}}%</span>
                            @else
                                <span class="current-price">{{number_format($product->Price,0,',','.')}}đ</span>
                            @endif
                        </div>
                        <div>{!!$product->ShortDes!!}</div>

                        <div class="shop-single-material pt-3">
                            <div class="list_option_">
                                @foreach($productArray['options'] as $optionIndex => $option)
                                    <div class="option_item">
                                        <h6 class="option_name">{{ $option['attribute']['AttributeName'] }}</h6>
                                        <div class="mb-1 d-flex">
                                            @foreach($option['properties'] as $propertyIndex => $property)
                                                <label class="d-flex mr-3 mb-3">
                                                                    <span class="d-inline-block mr-2"
                                                                          style="top: 0px; position: relative;">
                                                                        <input type="checkbox"
                                                                               onchange="selectOption(this)"
                                                                               class="input_option_"
                                                                               data-value="{{ $option['attribute']['idAttribute'] }}-{{ $property['idAttrValue'] }}"
                                                                               value="{{ $property['idAttrValue'] }}"
                                                                               id="option-{{ $optionIndex }}-property-{{ $propertyIndex }}"
                                                                               name="option-{{ $optionIndex }}">
                                                                    </span>
                                                    <span
                                                        class="d-inline-block text-black">{{ $property['AttrValName'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                @if(count($productArray['options']) == 0)
                                    <p>No attribute available</p>
                                @endif

                            </div>
                        </div>

                        <div class="mt-20 qty-of-attr-label">Còn Lại: <span id="product_quantity"
                                                                            class="h5">{{ $product->QuantityTotal }}</span>
                            sản phẩm
                        </div>

                        @if ($pd_color_count > 0)
                            <div class="shop-single-material pt-3">
                                <div class="material-title col-lg-2">Phiên bản:</div>
                                <a href="{{URL::to('/shop-single/'.$product->ProductSlug)}}">
                                    <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                         alt="" style="height: 50px; wight: 50px;">
                                </a>
                                @foreach($pd_colors as $key => $pd)
                                    <div>
                                            <?php $image_pd = json_decode($pd->ImageName)[0]; ?>
                                        <a href="{{URL::to('/shop-single/'.$pd->ProductSlug)}}">
                                            <img src="{{asset('public/storage/kidoldash/images/product/'.$image_pd)}}"
                                                 alt="" style="height: 50px; wight: 50px;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{URL::to('/buy-now')}}" id="form-buy-now">
                            @csrf
                            <div class="product-quantity d-flex flex-wrap align-items-center pt-30">
                                <span class="quantity-title">Số Lượng: </span>
                                <div class="quantity d-flex align-items-center">
                                    <button type="button" class="sub-qty"><i class="ti-minus"></i></button>
                                    <input type="number" class="qty-buy" name="qty_buy" value="1"/>
                                    <button type="button" class="add-qty"><i class="ti-plus"></i></button>
                                </div>
                            </div>

                            <input type="hidden" name="idProduct" id="idProduct" value="{{$product->idProduct}}">
                            <input type="hidden" name="PriceNew" id="PriceNew" value="{{round($SalePrice,-3)}}">
                            <input type="hidden" id="AttributeProduct" name="AttributeProduct">
                            <input type="hidden" id="idProAttr" name="idProAttr">
                            <input class="qty-of-attr" id="qty_of_attr" name="qty_of_attr" type="hidden"
                                   value="">
                            <input type="hidden" id="product_option" name="product_option" value="">
                            <input type="hidden" id="proAttr" name="proAttr" value="">

                            <div class="text-primary alert-qty"></div>

                            <div class="product-action d-flex flex-wrap">
                                <div class="action">
                                    <button type="button" class="btn btn-primary add-to-cart">Thêm vào giỏ hàng</button>
                                </div>
                                <div class="action">
                                    <a class="add-to-wishlist" data-id="{{$product->idProduct}}" data-tooltip="tooltip"
                                       data-placement="right" title="Thêm vào yêu thích"><i class="fa fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="text-primary alert-add-to-cart"></div>

                            <div class="dynamic-checkout-button">
                                <div class="checkout-btn">
                                    <button type="submit" class="btn btn-primary buy-now" value="Mua ngay">
                                        Mua ngay
                                    </button>
                                </div>
                            </div>
                            <div class="text-primary alert-buy-now"></div>
                            <?php
                            $error = Session::get('error');
                            if ($error) {
                                echo '<div class="text-danger">' . $error . '</div>';
                                Session::put('error', null);
                            }
                            ?>
                        </form>

                        <!-- <div class="custom-payment-options">
                        <p>Phương thức thanh toán</p>

                        <ul class="payment-options">
                            <li><img src="{{asset('public/kidolshop/images/payment-icon/vnpay.png')}}" alt=""
                                style="wight:50px; height: 50px;">
                            </li>
                        </ul>
                    </div> -->

                    </div>
                </div>
            </div>
            <!--Shop Single End-->


            <!--Shop Single info Start-->
            <div class="shop-single-info">
                <div class="shop-info-tab">
                    <ul class="nav justify-content-center" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Mô tả
                                chi tiết</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                        <div class="description">
                            <p>{!!$product->DesProduct!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Shop Single End-->

    <!--New Product Start-->
    @if($list_related_product->count() > 0)
        <div class="new-product-area section-padding-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-9 col-sm-11">
                        <div class="section-title text-center">
                            <h2 class="title">Sản Phẩm Liên Quan</h2>
                        </div>
                    </div>
                </div>
                <div class="product-wrapper">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @foreach($list_related_product as $key => $related_product)
                                <div class="swiper-slide">
                                    <div class="single-product">
                                        <div class="product-image">
                                                <?php $image = json_decode($related_product->ImageName)[0]; ?>
                                            <a href="{{URL::to('/shop-single/'.$related_product->ProductSlug)}}">
                                                <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                                     alt="">
                                            </a>

                                                <?php
                                                $SalePrice = $related_product->Price;
                                                $get_time_sale = ProductController::get_sale_pd($related_product->idProduct);
                                                ?>

                                            @if($get_time_sale)
                                                    <?php $SalePrice = $related_product->Price - ($related_product->Price / 100) * $get_time_sale->Percent; ?>
                                                <div class="product-countdown">
                                                    <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                                </div>
                                                @if($related_product->QuantityTotal == '0')
                                                    <span class="sticker-new soldout-title">Hết hàng</span>
                                                @else
                                                    <span
                                                        class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                                @endif
                                            @elseif($related_product->QuantityTotal == '0')
                                                <span class="sticker-new soldout-title">Hết hàng</span>;
                                            @endif

                                            <div class="action-links">
                                                <ul>
                                                    <li><a class="add-to-compare"
                                                           data-idcat="{{$related_product->idCategory}}"
                                                           id="{{$related_product->idProduct}}" data-tooltip="tooltip"
                                                           data-placement="left" title="So sánh"><i
                                                                class="icon-sliders"></i></a></li>
                                                    <li><a class="add-to-wishlist"
                                                           data-id="{{$related_product->idProduct}}"
                                                           data-tooltip="tooltip" data-placement="left"
                                                           title="Thêm vào danh sách yêu thích"><i
                                                                class="icon-heart"></i></a></li>
                                                    <li><a class="quick-view-pd"
                                                           data-id="{{$related_product->idProduct}}"
                                                           data-tooltip="tooltip" data-placement="left"
                                                           title="Xem nhanh"><i class="icon-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-content text-center">
                                            <h4 class="product-name"><a
                                                    href="{{URL::to('/shop-single/'.$related_product->ProductSlug)}}">{{$related_product->ProductName}}</a>
                                            </h4>
                                            <div class="price-box">
                                                @if($SalePrice < $related_product->Price)
                                                    <span class="old-price">{{number_format($related_product->Price,0,',','.')}}đ</span>
                                                    <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                                @else
                                                    <span class="current-price">{{number_format($related_product->Price,0,',','.')}}đ</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--New Product End-->

    <div id="modal-AddToCart">

    </div>

    <!--Brand Start-->
    <div class="brand-area">
        <div class="container">
            <div class="brand-active swiper-container">
                <div class="swiper-wrapper">
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/adidas.png')}}"
                             alt="" style="height: 80px; wight: 100px;">

                    </div>
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/converselogo.png')}}"
                             alt="" style="height: 80px; wight: 100px;">

                    </div>
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/newbalance.png')}}"
                             alt="" style="height: 80px; wight: 100px;">

                    </div>
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/nike.png')}}"
                             alt="" style="height: 80px; wight: 100px;">

                    </div>
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/puma.png')}}"
                             alt="" style="height: 80px; wight: 100px;">

                    </div>
                    <div class="single-brand swiper-slide">

                        <img src="{{asset('public/kidolshop/images/brand/reebok.png')}}"
                             alt="" style="height: 80px; wight: 100px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Brand End-->

    <!-- Validate QuantityBuy & Add vàoo Cart & Mua ngay -->
    <script>
        $(document).ready(function () {
            var idCustomer = '<?php echo Session::get('idCustomer'); ?>';
            var $Quantity = parseInt($('.qty-of-attr').val());
            $("input:radio[name=material]:first").attr('checked', true);
            $('#idProAttr').val($("input:radio[name=material]:first").val());

            var AttributeProduct = $('#AttributeName').val() + ': ' + $('.AttrValName').data("name");
            $('#AttributeProduct').val(AttributeProduct);

            $("input:radio[name=material]").on('click', function () {
                $(".qty-buy").val("1");
                clearAllAlerts();
                $idAttribute = $(this).attr("id");
                $AttrValName = $(this).data("name");
                $Quantity = $(this).data("qty");
                $('.qty-of-attr-label').html("Còn Lại: " + $Quantity);
                $('.qty-of-attr').val($Quantity);

                AttributeProduct = $('#AttributeName').val() + ': ' + $AttrValName;
                $('#AttributeProduct').val(AttributeProduct);

                $('#idProAttr').val($("#" + $idAttribute).val());
            });

            function clearAllAlerts() {
                $('.alert-qty').html("");
                $('.alert-add-to-cart').html("");
                $('.alert-buy-now').html("");
            }

            function validateQuantity() {
                var qty = parseFloat($('.qty-buy').val());
                if (isNaN(qty) || qty <= 0 || !Number.isInteger(qty)) {
                    $('.alert-qty').html("Vui lòng nhập số lượng hợp lệ!");
                    return false;
                }
                if (qty > $Quantity) {
                    $('.alert-qty').html("Vượt quá số lượng sản phẩm hiện có!");
                    return false;
                }
                $('.alert-qty').html(""); // Clear error message when quantity is valid
                return true;
            }

            $('.add-qty').on('click', function () {
                var $input = $(this).prev();
                var currentValue = parseInt($input.val());
                if (currentValue >= $Quantity) {
                    $('.alert-qty').html("Vượt quá số lượng sản phẩm hiện có!");
                } else {
                    $input.val(currentValue + 1);
                    clearAllAlerts(); // Clear error messages when quantity is valid
                }
            });

            $('.sub-qty').on('click', function () {
                var $input = $(this).next();
                var currentValue = parseInt($input.val());
                if (currentValue > 1) {
                    $input.val(currentValue - 1);
                    if ($input.val() > $Quantity) {
                        $('.alert-qty').html("Vượt quá số lượng sản phẩm hiện có!");
                        $('.alert-add-to-cart').html(""); // Clear add to cart error message
                        $('.alert-buy-now').html(""); // Clear buy now error message
                    } else {
                        clearAllAlerts(); // Clear error messages when quantity is valid
                    }
                } else {
                    $('.alert-qty').html("Số lượng phải lớn hơn hoặc bằng 1!");
                }
            });

            $('.qty-buy').on('input', function () {
                if (validateQuantity()) {
                    clearAllAlerts(); // Clear error messages when quantity is valid
                }
            });

            function checkCustomerStatus(callback) {
                $.ajax({
                    url: '{{url("/get-customer-status")}}',
                    method: 'GET',
                    success: function (response) {
                        callback(response.status);
                    },
                    error: function () {
                        callback(null);
                    }
                });
            }

            $('.buy-now').on('click', function (e) {
                if (!validateQuantity()) {
                    $('.alert-buy-now').html("Vui lòng nhập số lượng hợp lệ!");
                    e.preventDefault();
                } else if ($(".qty-buy").val() > $Quantity) {
                    $('.alert-buy-now').html("Vượt quá số lượng sản phẩm hiện có!");
                    e.preventDefault();
                } else {
                    $('.alert-buy-now').html(""); // Clear error message when quantity is valid
                }
            });
            // Không click chọn thuộc tính sản phẩm khi thêm vào giỏ
            $('.add-to-cart').on('click', function () {
                let countChecked = $('input.input_option_:checked').length;
                if (countChecked == 0) {
                    alert('Vui lòng chọn thuộc tính sản phẩm');
                    return;
                }

                checkCustomerStatus(function (customerStatus) {
                    if (customerStatus === 0) { // Kiểm tra trạng thái tài khoản
                        Swal.fire({
                            icon: 'warning',
                            title: '<span style="color: red;">Mua hàng thất bại</span>',
                            text: 'Tài khoản của bạn đã bị khóa.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{url("/login")}}'; // Đăng xuất
                            }
                        });
                    } else if (!validateQuantity()) {
                        $('.alert-add-to-cart').html("Vui lòng nhập số lượng hợp lệ!");
                    } else if (idCustomer == "") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Bạn chưa đăng nhập',
                            text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.',
                            confirmButtonText: 'Đăng nhập',
                            showCancelButton: true,
                            cancelButtonText: 'Hủy'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../login';
                            }
                        });
                    } else if ($(".qty-buy").val() > $Quantity) {
                        $('.alert-add-to-cart').html("Vượt quá số lượng sản phẩm hiện có!");
                    } else {
                        $('.alert-add-to-cart').html(""); // Clear error message when quantity is valid

                        var idProduct = $('#idProduct').val();
                        var AttributeProduct = $('#AttributeProduct').val();
                        var QuantityBuy = $('.qty-buy').val();
                        var PriceNew = $('#PriceNew').val();
                        var _token = $('input[name="_token"]').val();
                        var qty_of_attr = $('.qty-of-attr').val();
                        var proAttr = $('#product_option').val();

                        $.ajax({
                            url: '{{url("/add-to-cart")}}',
                            method: 'POST',
                            data: {
                                idProduct: idProduct,
                                proAttr: proAttr,
                                AttributeProduct: AttributeProduct,
                                QuantityBuy: QuantityBuy,
                                PriceNew: PriceNew,
                                qty_of_attr: qty_of_attr,
                                _token: _token
                            },
                            success: function (data) {
                                $('#modal-AddToCart').html(data);
                                $('.modal-AddToCart').modal('show');

                                $(document).on('click', '#continue-shopping', function () {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        async function selectOption(el) {
            let input_option_ = $('.input_option_');

            let parent = $(el).closest('.option_item');
            let list_ = parent.find('.input_option_');

            list_.each(function () {
                if (this === el && this.checked) {
                    list_.not(this).prop('checked', false);
                }
            });

            let list_option;
            let arr_option = [];
            input_option_.each(function () {
                if ($(this).is(':checked')) {
                    arr_option.push($(this).val());
                }
            })

            list_option = arr_option.join(',');
            await optionProduct(list_option, '{{ $product->idProduct }}');
        }

        async function optionProduct(option, id) {
            const url = `{{ route('api.products.info') }}?op=${option}&id=${id}`;

            await $.ajax({
                url: url,
                type: 'GET',
                async: false,
                success: function (res, textStatus) {
                    let pro_op = res.data;

                    if (pro_op) {
                        let product_quantity = pro_op.Quantity;
                        let product_option = pro_op.idProAttr;

                        $('#product_quantity').text(product_quantity);
                        $('#qty_of_attr').val(product_quantity);
                        $('#product_option').val(product_option);
                        $('#proAttr').val(product_option);
                    }
                },
                error: function (request, status, error) {
                    let data = JSON.parse(request.responseText);
                    alert(data.message);
                }
            });
        }
        // Chọn thuộc tính sản phẩm
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("form-buy-now");

            form.addEventListener("submit", function (event) {
                event.preventDefault();
                let countChecked = $('input.input_option_:checked').length;
                if (countChecked == 0) {
                    alert('Vui lòng chọn thuộc tính sản phẩm');
                    return;
                }

                form.submit();
            });
        });

    </script>
@endsection
