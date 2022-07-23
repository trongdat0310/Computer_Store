@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Hiển thị tất cả mã giảm giá
            </div>
            <?php
            use Illuminate\Support\Facades\Session;

            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="button">Go!</button>
                </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên mã giảm <giá></giá></th>
                        <th>Mã giảm giá</th>
                        <th>Số lượng mã giảm giá</th>
                        <th>Tính năng mã</th>
                        <th>Số phần trăm giảm hoặc số tiền giảm</th>
                        <th style="width:110px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_coupon as $key => $all_coupons)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$all_coupons->coupon_name}}</td>
                            <td>{{$all_coupons->coupon_code}}</td>
                            <td>{{$all_coupons->coupon_time}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if($all_coupons->coupon_condition==1){
                                        print_r('Giảm theo phần trăm');
                                    }elseif($all_coupons->coupon_condition==2){
                                        print_r('Giảm theo tiền');
                                    }
                                ?>

                            </span></td>

                            <td>
                                <?php
                                if($all_coupons->coupon_condition==1){
                                    echo('Giảm '.$all_coupons->coupon_number.'%');
                                }elseif($all_coupons->coupon_condition==2){
                                    echo('Giảm '.$all_coupons->coupon_number.'đ');
                                }
                                ?>
                            </td>
                            <td>
                                <a href="{{URL::to('/edit-coupon/'.$all_coupons->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('Bạn có chắc là muốn xóa mã giảm giá này ko?')" href="{{URL::to('/delete-coupon/'.$all_coupons->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
