@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê đơn hàng
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
                        <th>Mã đơn hàng</th>
                        <th>Tình trạng đơn hàng</th>
                        <th>Mã giảm giá</th>
                        <th>Ngày đặt</th>
                        <th style="width:110px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order as $key => $orders)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$orders->order_code}}</td>
                            <td><span class="text-ellipsis">
                            @if($orders->order_status==1)
                                Đơn hàng mới
                            @else
                                Đã xử lý
                            @endif

                            </span></td>
                            <td>
                                @if($orders->coupon_code != 'no')
                                    {{$orders->coupon_code}}
                                @else
                                    Không có mã
                                @endif
                            </td>
                            <td>{{$orders->created_at}}</td>
                            <td>
                                <a href="{{URL::to('/details-order/'.$orders->order_code)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu này ko?')" href="{{URL::to('/delete-brand-product/'.$orders->orders_code)}}" class="active styling-edit" ui-toggle-class="">
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
