@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin người mua
        </div>
        <?php
            use Illuminate\Support\Facades\Session;

            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Tên tài khoản</th>
                    <th>Số điện thoại</th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{$order->customer->customer_name}}</td>
                            <td>{{$order->customer->customer_phone}}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin vận chuyển
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Tên người nhận</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Ghi chú</th>
                    <th>Hình thức than toán</th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{$order->shipping->shipping_name}}</td>
                            <td>{{$order->shipping->shipping_address}}</td>
                            <td>{{$order->shipping->shipping_phone}}</td>
                            <td>{{$order->shipping->shipping_note}}</td>
                            @if($order->shipping->shipping_method == 0)
                                <td>Thanh toán khi nhận hàng</td>
                            @else
                                <td>Thanh toán bằng ATM</td>
                            @endif
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết đơn hàng
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Tổng tiền</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $total = 0;
                ?>

                    @foreach($details_order as $key => $details_orders)
                        @foreach($details_orders->product as $products)
                            @php
                                $sub_total = $details_orders->product_sales_quantity*$products->product_price;
                                $total += $sub_total;
                            @endphp
                        <tr>
                            <td>{{$products->product_name}}</td>
                            <td>{{$details_orders->product_sales_quantity}}</td>
                            <td>{{number_format($products->product_price).'đ'}}</td>
                            <td>{{number_format($sub_total).'đ'}}</td>
                        </tr>
                        @endforeach
                    @endforeach

                <tr>
                    <td style="color: #DA8028">
                        <table>
                            <tr>
                                <td>Tổng tiền sản phẩm :</td>
                                <td>{{number_format($total).' đ'}}</td>
                            </tr>
                            <tr>
                                <td>Phí vận chuyển :</td>
                                <td>{{number_format($order_fee = $order->order_fee).' đ'}}</td>
                            </tr>
                            @if($order->coupon_code != 'no')
                                <tr>
                                    <td>Mã giảm giá :</td>
                                    <td>{{$order->coupon->coupon_name}}</td>
                                </tr>
                                <tr>
                                    @if($coupon_condition == 1)
                                        <td>Tổng được giảm :</td> <td>- {{number_format(($total*$coupon_number)/100).' đ'}}</td>
                                        <tr>
                                            <td>Tổng thanh toán :</td> <td>{{number_format($total-($total*$coupon_number)/100+$order_fee).' đ'}}</td>
                                        </tr>

                                    @else
                                        <td>Tổng được giảm :</td> <td>- {{number_format($coupon_number).' đ'}}</td>
                                        <tr>
                                            <td>Tổng thanh toán :</td>
                                            <td>{{number_format($total-$coupon_number+$order_fee).' đ'}}</td>
                                        </tr>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td>Tổng thanh toán :</td> <td>{{number_format($total).' đ'}}</td>
                                </tr>
                            @endif

                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a target="_blank" href="{{url('/print-order/'.$order->order_code)}}"><input type="button" value="In đơn hàng" name="" class="btn btn-primary btn-sm"></a>
</div>

@endsection
