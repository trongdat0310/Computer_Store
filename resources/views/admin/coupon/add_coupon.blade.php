@extends('admin_layout')
@section('admin_content')
    <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Thêm Mã giảm giá
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" action="{{URL::to('/save-coupon')}}" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Mã giảm giá</label>
                                    <input type="text" name="coupon_name" class="form-control" placeholder="Nhập tên mã giảm giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã giảm giá</label>
                                    <input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã giảm giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã</label>
                                    <input type="text" name="coupon_time" class="form-control" placeholder="Nhập số lượng mã">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tính năng mã</label>
                                    <select name="coupon_condition" class="form-control input-lg m-bot15">
                                        <option value="0">---Chọn---</option>
                                        <option value="1">Giảm theo phần trăm</option>
                                        <option value="2">Giảm theo tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nhập số % hoặc số tiền giảm</label>
                                    <input type="text" name="coupon_number" class="form-control" placeholder="Nhập tên danh mục">
                                </div>
                                <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã giảm giá</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
