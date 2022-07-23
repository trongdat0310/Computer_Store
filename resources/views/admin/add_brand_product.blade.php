@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-brand-product')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên Thương hiệu</label>
                            <input type="text" name="brand_product_name" class="form-control" placeholder="Nhập tên Thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả Thương hiệu</label>
                            <textarea style="resize: none" rows="8" type="text" name="brand_product_desc" class="form-control" placeholder="Mô tả Thương hiệu"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa Thương hiệu</label>
                            <textarea style="resize: none" rows="8" type="text" name="brand_product_keyword" class="form-control" placeholder="Từ khóa Thương hiệu"></textarea>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="brand_product_status" class="form-control input-lg m-bot15">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="add_brand_product" class="btn btn-info">Thêm Thương hiệu</button>
                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection