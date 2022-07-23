@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhập Danh mục sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-category-product/'.$edit_category_product->category_id)}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_category_product->category_name}}" name="category_product_name" class="form-control" placeholder="Nhập tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize: none" rows="8" type="text" name="category_product_desc" class="form-control" placeholder="Mô tả danh mục">{{$edit_category_product->category_name}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa danh mục</label>
                            <textarea style="resize: none" rows="8" type="text" name="category_product_keyword" class="form-control" placeholder="Từ khóa danh mục">{{$edit_category_product->meta_keyword}}</textarea>
                        </div>
                        <button type="submit" name="update_category_product" class="btn btn-info">Cập nhập danh mục</button>
                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
