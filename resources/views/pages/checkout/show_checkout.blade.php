@extends('shopping_layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán</li>
            </ol>
        </div><!--/breadcrums-->
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <?php
                            use Illuminate\Support\Facades\Session;
                            use Gloudemans\Shoppingcart\Facades\Cart;
                        ?>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                            </div>
                        @endif
                        <p>Thông tin gửi hàng</p>
                        <div class="form-one">
                            <form>
                                {{csrf_field()}}
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên*">
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ*">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại*">
                                <textarea name="shipping_note" class="shipping_note" placeholder="Ghi chú" rows="5"></textarea>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn hình thức thanh toán</label>
                                    <select name="shipping_method" id="shipping_method" class="form-control input-lg m-bot15 shipping_method">
                                        <option value="0">Thanh toán khi nhận hàng</option>
                                        <option value="1">Thanh toán bằng ATM</option>
                                    </select>
                                </div>
                                @if(Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                                @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="25000">
                                @endif
                                @if(Session::get('coupon_array'))
                                    @foreach(Session::get('coupon_array') as $coupons)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$coupons['coupon_code']}}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                @endif
                                    <input type="button" value="Gửi" name="send_order" class="btn btn-primary btn-sm send_order">
                            </form>
                            <form>
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thành phố</label>
                                    <select name="city" id="city" class="form-control input-lg m-bot15 choose city">
                                        <option value="">---Chọn Thành Phố---</option>
                                        @foreach($city as $citys)
                                            <option value="{{$citys->city_id}}">{{$citys->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên quận huyện</label>
                                    <select name="province" id="province" class="form-control input-lg m-bot15 choose province">
                                        <option value="0">---Chọn Quận Huyện---</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên xã phường</label>
                                    <select name="wards" id="wards" class="form-control input-lg m-bot15 wards">
                                        <option value="0">---Chọn Xã Phường---</option>
                                    </select>
                                </div>
                                <input type="submit" value="Tính phí vận chuyển" name="caculate_delivery" class="btn btn-primary btn-sm caculate_delivery">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 clearfix">
                    <div class="table-responsive cart_info">
                        <?php
                            $content = Cart::content();
                            $total = 0;
                            $total_coupon = 0;
                            $feeship = 0;
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
                                        <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                            {{csrf_field()}}
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
                                                    <input type="hidden" name="rowId_cart" value="{{$v_content->rowId}}" class="form-control" id="">
                                                </div>
                                                <input type="submit" value="Cập nhập giỏ hàng" name="update_qty" class="btn btn-default check_out">
                                            </td>
                                        </form>
                                        <td class="cart_total">
                                            <p class="cart_total_price">
                                                <?php
                                                $subtotal = $v_content->price * $v_content->qty;
                                                $total+=$subtotal;
                                                echo number_format($subtotal).' '.'VNĐ';

                                                ?>
                                            </p>
                                        </td>
                                        <td class="cart_delete">
                                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($content->first() != null)
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            <a class="btn btn-default check_out" href="{{URL::to('/delete-all-cart/')}}">Xóa giỏ hàng</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                        @if($content->first() == null)
                            {{Session::put('coupon_array',null)}}
                            <h4 style="text-align: center">
                                Bạn chưa có gì trong giỏ hàng cả. Hãy mua sắm nào!
                                <br><br>
                                <a href="{{URL::to('/')}}"><i class="fa fa-shopping-cart"></i> Mua sắm</a>
                            </h4>
                        @endif
                    </div>
                    @if($content->first() != null)
                        <section id="do_action">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="chose_area">
                                            <form method="POST" action="{{url('/check-coupon')}}">
                                                {{csrf_field()}}
                                                <ul><input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã giảm giá"></ul><br>
                                                <ul><input type="submit" class="btn btn-default check_out check_coupon" name="check_coupon" value="Tính mã giảm giá"></ul>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="total_area">
                                            <ul>
                                                <li>Tổng tiền: <span>{{Cart::pricetotal(0)}}đ</span></li>
                                                {{--                            <li>Thuế: <span>{{Cart::tax(0).' '.'VNĐ'}}</span></li>--}}

                                                @if(Session::get('fee'))
                                                    <li>
                                                        <a class="" href="{{URL::to('/delete-fee/')}}"><i class="fa fa-times"></i></a>
                                                        Phí vận chuyển: <span>{{$feeship = Session::get('fee')}}</span>
                                                    </li>
                                                @endif

                                                @if(Session::get('coupon_array'))
                                                    <li>
                                                        <a class="" href="{{URL::to('/delete-coupon/')}}"><i class="fa fa-times"></i></a>
                                                        @foreach(Session::get('coupon_array') as $key => $cou)
                                                            @if($cou['coupon_condition']==1)
                                                                {{--                                        <span>{{$cou['coupon_number']}}%--}}
                                                                @php
                                                                    $total_coupon = ($total * ($cou['coupon_number']/100));
                                                                    echo 'Tổng cộng vocher giảm giá: <span> - '.number_format($total_coupon,0,',','.').'đ</span>';
                                                                @endphp
                                                            @else
                                                                {{--                                        {{number_format($cou['coupon_number'],0,',','.')}}đ--}}
                                                                @php
                                                                    $total_coupon = $cou['coupon_number'];
                                                                    echo 'Tổng cộng vocher giảm giá: <span> - '.number_format($total_coupon,0,',','.').'đ</span>';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    </li>
                                                @endif
                                                <li style="font-weight: bolder;">Tổng thanh toán: <span style="color: orange">{{number_format($total-$total_coupon+$feeship,0,',','.')}}đ</span></li>
                                            </ul>

                                            <?php
                                            $customer_id = Session::get('customer_id');
                                            $shipping_id = Session::get('shipping_id');
                                            if($customer_id!=NULL && $shipping_id==NULL){
                                            ?>
                                            <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
                                            <?php
                                            }elseif($customer_id!=NULL && $shipping_id!=NULL){
                                            ?>
                                            <a class="btn btn-default check_out" href="{{URL::to('/payment')}}">Thanh toán</a>
                                            <?php
                                            }else{
                                            ?>
                                            <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section><!--/#do_action-->
                    @endif
                </div>
            </div>
        </div>
    </div>
</section> <!--/#cart_items-->

@endsection
