@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhập Thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_brand_product->brand_id)}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên Thương hiệu</label>
                            <input type="text" value="{{$edit_brand_product->brand_name}}" name="brand_product_name" class="form-control" placeholder="Nhập tên Thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả Thương hiệu</label>
                            <textarea style="resize: none" rows="8" type="text" name="brand_product_desc" class="form-control" placeholder="Mô tả Thương hiệu">{{$edit_brand_product->brand_name}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa Thương hiệu</label>
                            <textarea style="resize: none" rows="8" type="text" name="brand_product_keyword" class="form-control" placeholder="Từ khóa Thương hiệu">{{$edit_brand_product->meta_keyword}}</textarea>
                        </div>
                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhập Thương hiệu</button>
                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
