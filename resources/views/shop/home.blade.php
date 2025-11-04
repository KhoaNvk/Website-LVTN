@extends('shop_layout')
@section('content')

<?php use App\Http\Controllers\ProductController; ?>
<!--Slider Start-->
<div class="slider-area">
    <div class="swiper-container slider-active">
        <div class="swiper-wrapper">
            <!--Single Slider Start-->
            <div class="single-slider swiper-slide animation-style-01" 
                style="background-image: url('public/kidolshop/images/banner/bg2.jpg'); height: 550px;">
                <div class="container">
                    <div class="slider-content">
</br>
                        <h2 class="main-title">Giảm giá sốc</h2>
                        <ul class="slider-btn">
                            <li><a href="{{URL::to('/store')}}" class="btn btn-round btn-primary">Bắt đầu mua sắm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Single Slider End-->

            <!--Single Slider Start-->
            <div class="single-slider swiper-slide animation-style-01" 
                style="background-image: url('public/kidolshop/images/banner/bg3.jpg'); height: 550px;">
                <div class="container" style="text-align:right;">
                    <div class="slider-content">
                        <h2 class="main-title">Ưu đãi hấp dẫn</h2>
                        <ul class="slider-btn">
                            <li><a href="{{URL::to('/store')}}" class="btn btn-round btn-primary">Bắt đầu mua sắm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Single Slider End-->
        </div>
        <!--Swiper Wrapper End-->

        <!-- Add Arrows -->
        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>

    </div>
    <!--Swiper Container End-->
</div>
<!--Slider End-->

<!--Shipping Start-->
<div class="shipping-area section-padding-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Free-Delivery.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Miễn Phí Vận Chuyển</h5>
                        <p style="font-family: 'Coiny', sans-serif;">Đơn từ <span style="color: red;">1 triệu</span> hoặc mua từ <span style="color: red;">2 sản phẩm</span> trở lên</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Online-Order.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Đặt Hàng Online</h5>
                        <p style="font-family: 'Coiny', sans-serif;">Lựa chọn các sản phẩm ưng ý và đặt hàng nhanh chóng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Freshness.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Hiện Đại</h5>
                        <p style="font-family: 'Coiny', sans-serif;">Luôn cập nhật các sản phẩm mới nhất</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-shipping">
                    <div class="shipping-icon">
                        <img src="public/kidolshop/images/shipping-icon/Made-By-Artists.png" alt="">
                    </div>
                    <div class="shipping-content">
                        <h5 class="title">Hỗ Trợ 24/7</h5>
                        <p style="font-family: 'Coiny', sans-serif;">Tư vấn hỗ trợ mọi lúc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Shipping End-->

<!--About Start-->
<div class="about-area section-padding-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="public/kidolshop/images/banner/shoe.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="title">Mua sắm thả ga với đa dạng voucher giảm giá.</h2>
                    <p>Các mã giảm giá hiện có trên cửa hàng:</p>
                    <ul>
                        <li> <span style="color: red;">freeship</span> : Giảm phí vận chuyển tối đa 30K cho đơn từ 0Đ (Có hạn). </li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!--About End-->

<!--Category Start-->

<div class="features-product-area section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Danh mục sản phẩm</h2>
                </div>
            </div>
        </div>

        <div class="category-slider-wrapper position-relative">
            <div class="swiper category-swiper">
                <div class="swiper-wrapper">
                    @foreach($list_category as $category)
                    <div class="swiper-slide">
                        <div class="single-category text-center mb-2 position-relative">
                            <a href="{{URL::to('/store?category='.$category->idCategory)}}" class="d-block position-relative">
                                <img src="{{asset('public/storage/kidoldash/images/category/'.$category->CategoryImage)}}" 
                                     alt="{{$category->CategoryName}}" 
                                     style="height: 200px; width: 100%; object-fit: cover;">
                                <div class="category-overlay">
                                    <h4 class="category-name">{{$category->CategoryName}}</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Nút điều hướng -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

<!--New Product Start-->
<div class="features-product-area section-padding-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9 col-sm-11">
                <div class="section-title text-center">
                    <h2 class="title">Sản Phẩm Của Chúng Tôi</h2>
                </div>
            </div>
        </div>
        <div class="product-wrapper">
            <div class="product-tab-menu">
                <ul class="nav justify-content-center" role="tablist">
                    <li>
                        <a class="active" data-toggle="tab" href="#tab3" role="tab">Bán chạy</a>
                    </li>
                    <!-- <li>
                        <a data-toggle="tab" href="#tab1" role="tab">Đang Sale</a>
                    </li> -->
                    <li>
                        <a data-toggle="tab" href="#tab2" role="tab">Chính sách đổi trả</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content product-items-tab">
                <div class="tab-pane fade show active" id="tab3" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @foreach($list_bestsellers_pd as $key => $bestsellers_pd)
                            <div class="swiper-slide">
                                <div class="single-product">
                                    <div class="product-image">
                                        <?php $image = json_decode($bestsellers_pd->ImageName)[0];?>
                                        <a href="{{URL::to('/shop-single/'.$bestsellers_pd->ProductSlug)}}">
                                            <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                        </a>

                                        <?php
                                            $SalePrice = $bestsellers_pd->Price;  
                                            $get_time_sale = ProductController::get_sale_pd($bestsellers_pd->idProduct); 
                                        ?>

                                        @if($get_time_sale)
                                            <?php $SalePrice = $bestsellers_pd->Price - ($bestsellers_pd->Price/100) * $get_time_sale->Percent; ?>
                                            <div class="product-countdown">
                                                <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                            </div>
                                            @if($bestsellers_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>
                                            @else <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                            @endif
                                        @elseif($bestsellers_pd->QuantityTotal == '0') <span class="sticker-new soldout-title">Hết hàng</span>;
                                        @endif

                                        <div class="action-links">
                                            <ul>
                                                <li><a class="add-to-compare" data-idcat="{{$bestsellers_pd->idCategory}}" id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                                <li><a class="add-to-wishlist" data-id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                                <li><a class="quick-view-pd" data-id="{{$bestsellers_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$bestsellers_pd->ProductSlug)}}">{{$bestsellers_pd->ProductName}}</a></h4>
                                        <div class="price-box">
                                            @if($SalePrice < $bestsellers_pd->Price)
                                                <span class="old-price">{{number_format($bestsellers_pd->Price,0,',','.')}}đ</span>
                                                <span class="current-price">{{number_format(round($SalePrice,-3),0,',','.')}}đ</span>
                                            @else
                                                <span class="current-price">{{number_format($bestsellers_pd->Price,0,',','.')}}đ</span>
                                            @endif
                                        </div>
                                        <div class="">
                                            Đã bán {{$bestsellers_pd->Sold}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab1" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            @php
                                $hasSaleProducts = false;
                            @endphp
                            
                            @foreach($list_featured_pd as $key => $featured_pd)
                                <?php
                                    $SalePrice = $featured_pd->Price;  
                                    $get_time_sale = ProductController::get_sale_pd($featured_pd->idProduct); 
                                ?>
                                @if($get_time_sale)
                                    @php
                                        $hasSaleProducts = true;
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="single-product">
                                            <div class="product-image">
                                                <?php $image = json_decode($featured_pd->ImageName)[0]; ?>
                                                <a href="{{URL::to('/shop-single/'.$featured_pd->ProductSlug)}}">
                                                    <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                                </a>
                                                <?php $SalePrice = $featured_pd->Price - ($featured_pd->Price / 100) * $get_time_sale->Percent; ?>
                                                <div class="product-countdown">
                                                    <div data-countdown="{{$get_time_sale->SaleEnd}}"></div>
                                                </div>
                                                @if($featured_pd->QuantityTotal == '0') 
                                                    <span class="sticker-new soldout-title">Hết hàng</span>
                                                @else 
                                                    <span class="sticker-new label-sale">-{{$get_time_sale->Percent}}%</span>
                                                @endif
                                                <div class="action-links">
                                                    <ul>
                                                        <li><a class="add-to-compare" data-idcat="{{$featured_pd->idCategory}}" id="{{$featured_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="So sánh"><i class="icon-sliders"></i></a></li>
                                                        <li><a class="add-to-wishlist" data-id="{{$featured_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Thêm vào danh sách yêu thích"><i class="icon-heart"></i></a></li>
                                                        <li><a class="quick-view-pd" data-id="{{$featured_pd->idProduct}}" data-tooltip="tooltip" data-placement="left" title="Xem nhanh"><i class="icon-eye"></i></a></li> 
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content text-center">
                                                <h4 class="product-name"><a href="{{URL::to('/shop-single/'.$featured_pd->ProductSlug)}}">{{$featured_pd->ProductName}}</a></h4>
                                                <div class="price-box">
                                                    @if($SalePrice < $featured_pd->Price)
                                                        <span class="old-price">{{number_format($featured_pd->Price, 0, ',', '.')}}đ</span>
                                                        <span class="current-price">{{number_format(round($SalePrice, -3), 0, ',', '.')}}đ</span>
                                                    @else
                                                        <span class="current-price">{{number_format($featured_pd->Price, 0, ',', '.')}}đ</span>
                                                    @endif
                                                </div>
                                                <div class="">
                                                    Đã bán {{$featured_pd->Sold}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if(!$hasSaleProducts)
                                <span style="display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            height: 250px;
                                            width: 100%;
                                            text-align: center;
                                            color: red;">
                                    Hiện tại chưa có đợt sale nào
                                </span>
                            @endif
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-next"><i class="fa fa-angle-right"></i></div>
                        <div class="swiper-prev"><i class="fa fa-angle-left"></i></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel">
                    <div class="swiper-container product-active">
                        <div class="swiper-wrapper">
                            <span style="display: flex; justify-content: center; align-items: center;
                                            height: 250px; width: 100%; text-align: center; ">
                                🔹 Chính sách đổi trả King Shoes 🔹</br>
                                - Miễn phí đổi hàng cho khách mua ở King Shoes trong trường hợp bị lỗi từ nhà sản xuất, 
                                giao nhầm hàng, nhầm size. </br>
                                - Quay video mở sản phẩm khi nhận hàng, nếu không có video unbox, 
                                khi phát hiện lỗi phải báo ngay cho King Shoes trong 1 ngày tính từ ngày giao hàng thành công. 
                                Qua 1 ngày chúng mình không giải quyết khi không có video unbox. </br>
                                - Sản phẩm đổi trong thời gian 3 ngày kể từ ngày nhận hàng. </br>
                                - Sản phẩm còn mới nguyên tem, tags, sản phẩm không dơ bẩn, 
                                hư hỏng bởi những tác nhân bên ngoài cửa hàng sau khi mua hàng. </br>
                                - Khi đổi trả vui lòng liên hệ qua chat tư vấn. </br>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--New Product End-->



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

@if(session('message'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Thông báo',
            text: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = '{{ route('login') }}';
        });
    </script>
@endif
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const swiper = new Swiper(".category-swiper", {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            
            breakpoints: {
                0: { slidesPerView: 1 },
                576: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                992: { slidesPerView: 4 }
            }
        });
    });
</script>
@endsection