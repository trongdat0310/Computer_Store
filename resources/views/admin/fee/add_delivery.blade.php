@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Vận chuyển
                </header>
                <?php
                use Illuminate\Support\Facades\Session;

                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
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
                                <option value="">---Chọn Quận Huyện---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tên xã phường</label>
                            <select name="wards" id="wards" class="form-control input-lg m-bot15 wards">
                                <option value="">---Chọn Xã Phường---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Phí vận chuyển</label>
                            <input type="text" id="fee_ship" name="fee_ship" class="form-control fee_ship">
                        </div>
                            <button type="button" id="add_delivery" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                        </form>
                    </div><br>

                    <div id="load_delivery">

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
