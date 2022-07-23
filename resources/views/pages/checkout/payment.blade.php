@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->
        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <?php
                use Gloudemans\Shoppingcart\Facades\Cart;
                $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh sản phẩm</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $v_content)
                    <tr>
                        <td class="cart_product">
                        <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" width="140" height="140" alt="" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Mã sản phẩm: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
                                    <input type="hidden" name="rowId_cart" value="{{$v_content->rowId}}" class="form-control" id="">
                                    <input type="submit" value="Cập nhập" name="update_qty" class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo number_format($subtotal).' '.'VNĐ';
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
        <h4 style="margin:40px 0;font-size:20px;">Chọn hình thức thanh toán</h4>
        <form action="{{URL::to('/order-place')}}" method="POST">
            {{csrf_field()}}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="0" type="checkbox"> Trả bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Trả tiền khi nhận hàng</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Trả bằng thẻ ghi nợ</label>
                </span>
                    <label><input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm"></label>
                </span>
            </div>
        </form>
    </div>
</section> <!--/#cart_items-->

@endsection
