@extends('shopping_layout')
@section('content')
@foreach($details_product as $details_products)
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{URL::to('public/uploads/product/'.$details_products->product_image)}}" alt="" />
                <h3>ZOOM</h3>
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$details_products->product_image)}}" width="85px" height="85px" alt=""></a>
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$details_products->product_image)}}" width="85px" height="85px" alt=""></a>
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$details_products->product_image)}}" width="85px" height="85px" alt=""></a>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                    </a>
            </div>

        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="http://localhost/shopbanhang/public/fontend/images/product-details/new.jpg" class="newarrival" alt="" />
                <h2>{{$details_products->product_name}}</h2>
                <p>Mã sản phẩm: {{$details_products->product_id}}</p>
                <img src="http://localhost/shopbanhang/public/fontend/images/product-details/rating.png" alt="" />
                <form action="{{URL::to('/save-cart')}}" method="POST">
                    {{csrf_field()}}
                    <span>
                        <span>{{number_format($details_products->product_price).' '.'VNĐ'}}</span>
                        <label>Quantity:</label>
                        <input name="qty" type="number" min="1" value="1" />
                        <input name="productid_hidden" type="hidden" value="{{$details_products->product_id}}" />
                        <button type="submit" class="btn btn-fefault add-to-cart" name="add-to-cart">
                            <i class="fa fa-shopping-cart">Thêm giỏ hàng</i>
                        </button>
                    </span>
                </form>
                <p><b>Tình trạng:</b> Còn hàng</p>
                <p><b>Điều kiện:</b> Mới 100%</p>
                <p><b>Thương hiệu:</b> {{$details_products->brand->brand_name}}</p>
                <p><b>Danh mục:</b> {{$details_products->category->category_name}}</p>
                <p><b>Số lượng trong kho:</b> {{$details_products->product_quantity}}</p>
                <a href=""><img src="http://localhost/shopbanhang/public/fontend/images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                <div class="fb-share-button" data-href="http://localhost/Project/shopbanhang/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="false"></div>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->
    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả sản phẩm</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details" >
                {{$details_products->product_desc}}
            </div>

            <div class="tab-pane fade" id="companyprofile" >
                {{$details_products->product_content}}
            </div>


            <div class="tab-pane fade" id="reviews" >
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>

                    <form action="#">
                        <span>
                            <input type="text" placeholder="Your Name"/>
                            <input type="email" placeholder="Email Address"/>
                        </span>
                        <textarea name="" ></textarea>
                        <b>Rating: </b> <img src="http://localhost/shopbanhang/public/fontend/images/product-details/rating.png" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div><!--/category-tab-->

@endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach($related_product as $key => $lienquan)
                    <a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}">
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
                                        <h2>{{number_format($lienquan->product_price).' '.'VNĐ'}}</h2>
                                        <p>{{$lienquan->product_name}}</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>
        </div>
    </div><!--/recommended_items-->
@endsection
