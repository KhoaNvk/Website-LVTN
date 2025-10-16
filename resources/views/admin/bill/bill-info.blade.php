@extends('admin_layout')
@section('content_dash')

    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-block card-stretch card-height print rounded">
                        <div class="card-header d-flex justify-content-between bg-primary header-invoice">
                            <div class="iq-header-title">
                                <h4 class="card-title mb-0">Đơn hàng #{{$address->idBill}}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Họ và tên người nhận</th>
                                                <th scope="col">Số điện thoại</th>
                                                <th scope="col">Địa chỉ</th>
                                                <th scope="col">Phương thức thanh toán</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="padding-left:12px !important;">{{$address->CustomerName}}</td>
                                                <td style="padding-left:12px !important;">{{$address->PhoneNumber}}</td>
                                                <td style="padding-left:12px !important;">{{$address->Address}}</td>
                                                <td style="padding-left:12px !important;">
                                                    @if($address->Payment == 'vnpay')
                                                        Thanh toán trực tuyến VNPay
                                                    @else
                                                        Thanh toán khi nhận hàng (COD)
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="mb-3" style="color: red;">Chi tiết đơn hàng</h5>
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="text-center" scope="col">STT</th>
                                                <th scope="col">Sản phẩm</th>
                                                <th class="text-center" scope="col">Giá</th>
                                                <th class="text-center" scope="col">Số lượng</th>
                                                <th class="text-center" scope="col">Tổng</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $Total = 0; $ship = 0; $total_bill = 0; $discount = 0; ?>
                                            @foreach($list_bill_info as $key => $bill_info)
                                                    <?php $Total += ($bill_info->Price * $bill_info->QuantityBuy); ?>

                                                <tr>
                                                    <th class="text-center" scope="row">{{$key + 1}}</th>
                                                    <td class="row" style="border-bottom:0;">
                                                            <?php $image = json_decode($bill_info->ImageName)[0]; ?>
                                                        <img class="avatar-70 rounded"
                                                             src="{{asset('public/storage/kidoldash/images/product/'.$image)}}"
                                                             alt="">
                                                        <div class="ml-2" style="flex:1;">
                                                            <h6 class="mb-0">{{$bill_info->ProductName}}</h6>
                                                            <p class="mb-0">Mã sản phẩm: {{$bill_info->idProduct}}</p>
                                                            <div class="list-option mt-2 ">
                                                                @foreach($bill_info->attribute as $item)
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-start"
                                                                        style="gap: 10px;">
                                                                        <p class="mb-0">{{ $item['attribute']->AttributeName }}
                                                                            : </p>
                                                                        <p class="mb-0">{{ $item['property']->AttrValName }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"
                                                        style="border-bottom:0;">{{number_format($bill_info->Price,0,',','.')}}
                                                        đ
                                                    </td>
                                                    <td class="text-center"
                                                        style="border-bottom:0;">{{$bill_info->QuantityBuy}}</td>
                                                    <td class="text-center" style="border-bottom:0; color: red;">
                                                        <b>{{number_format($bill_info->Price * $bill_info->QuantityBuy,0,',','.')}}
                                                            đ</b></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-3">
                                <div class="col-lg-12">
                                    <div class="or-detail rounded">
                                        <div class="p-3 row">
                                            <h5 class="mb-3 col-lg-12" style="color: red;">Chi tiết đặt hàng</h5>
                                            <div class="mb-2 col-lg-10">
                                                <h6>Tổng tiền hàng</h6>
                                            </div>
                                            <div class="mb-2 col-lg-2 text-right">
                                                <h6>{{number_format($Total,0,',','.')}}đ</h6>
                                            </div>

                                            @php
                                                if ($Total < 1000000) {
                                                    $ship = 30000;
                                                    $total_bill = $Total + $ship;
                                                } else {
                                                    $ship = 0;
                                                    $total_bill = $Total;
                                                }
                                            @endphp
                                            <div class="mb-2 col-lg-10">
                                                <h6>Phí vận chuyển (Miễn phí vận chuyển cho đơn hàng trên
                                                    1.000.000đ)</h6>
                                            </div>
                                            <div class="mb-2 col-lg-2 text-right">
                                                <h6>
                                                    @if($ship > 0)
                                                        {{ number_format($ship, 0, ',', '.') }}đ
                                                    @else
                                                        Miễn phí
                                                    @endif
                                                </h6>
                                            </div>

                                            @if($address->Voucher != '')
                                                <div class="mb-2 col-lg-10">
                                                    <h6>Mã giảm giá</h6>
                                                </div>
                                                @php
                                                    $Voucher = explode("-",$address->Voucher);
                                                    $VoucherCondition = $Voucher[1];
                                                    $VoucherNumber = $Voucher[2];
                                                    if($VoucherCondition == 1) $discount = ($Total/100) * $VoucherNumber;
                                                    else{
                                                        $discount = $VoucherNumber;
                                                        if($discount > $Total) $discount = $Total;
                                                    }

                                                    $total_bill =  $total_bill - $discount;
                                                    if($total_bill < 0) $total_bill = $ship;
                                                @endphp
                                                <div class="mb-2 col-lg-2 text-right">
                                                    <h6>- {{number_format($discount,0,',','.')}}đ</h6>
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                            class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                                            <h6>Thành tiền</h6>
                                            <h3 class="text-primary font-weight-700">{{number_format($total_bill,0,',','.')}}
                                                đ</h3>
                                        </div>
                                    </div>
                                    @if($address->Payment == 'vnpay' || $address->Payment == 'momo')
                                        <div class="col-lg-3 paid_tag">
                                            <div class="h3 p-3 mb-0 text-primary">Đã thanh toán</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
