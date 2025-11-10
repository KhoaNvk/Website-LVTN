<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h2>Cảm ơn {{ $bill->CustomerName }} đã đặt hàng tại King Shoes!</h2>

    <p>Đơn hàng của bạn đã được ghi nhận với mã: <strong>#{{ $bill->idBill }}</strong></p>

    <h3>Chi tiết đơn hàng:</h3>
    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billInfo as $item)
                <tr>
                    <td>{{ $item->ProductName ?? 'Sản phẩm' }}</td>
                    <td>{{ $item->QuantityBuy }}</td>
                    <td>{{ number_format($item->Price, 0, ',', '.') }}₫</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Tổng tiền:</strong> {{ number_format($bill->TotalBill, 0, ',', '.') }}₫</p>
    <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($bill->Payment) }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $bill->Address }}</p>

    <p>Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng.</p>

    <p>Trân trọng,<br>Đội ngũ <strong>King Shoes</strong></p>
</body>
</html>
