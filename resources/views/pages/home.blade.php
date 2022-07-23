@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
    @foreach($all_product as $key => $product)

        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form action="{{URL::to('/save-cart')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}" name="productid_hidden">
                            <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                            <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{number_format($product->product_price).' '.'VNĐ'}}</h2>
                                <span>{{$product->product_name}}</span>
                            </a><br>

                            <button type="submit" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
                        </form>
                    </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
                {!! $all_product->links() !!}
            </ul>
        </div>
    </div>
</div><!--features_items-->
<div class="fb-page" data-href="https://www.facebook.com/gearvnhcm" data-tabs="messsenger" data-width="500"
     data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
     data-show-facepile="true"><blockquote cite="https://www.facebook.com/gearvnhcm"
     class="fb-xfbml-parse-ignore"><a href="https://www.facebook
     .com/gearvnhcm">Gearvn</a></blockquote>
</div><br><br><br>
@endsection
