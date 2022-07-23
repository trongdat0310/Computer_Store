@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Hiển thị tất cả slider
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
                        <th>Tên Sản phẩm</th>
                        <th>Hình ảnh Sản phẩm</th>
                        <th>Hiển thị</th>
                        <th>Mô tả</th>
                        <th style="width:110px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_slider as $key => $slider)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$slider->slider_name}}</td>
                            <td><img src='public/uploads/slider/{{$slider->slider_image}}' height="100" width="300"></td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if($slider->slider_status == 0){
                                    ?>
                                    <a href="{{URL::to('/unactive-slider/'.$slider->slider_id)}}"><i class="fa fa-thumbs-styling fa-thumbs-down" aria-hidden="true"></i></a>

                                <?php
                                    }else{
                                    ?>
                                    <a href="{{URL::to('/active-slider/'.$slider->slider_id)}}"><i class="fa fa-thumbs-styling fa-thumbs-up" aria-hidden="true"></i></a>
                                <?php
                                    }
                                    ?>

                            </span></td>
                            <td>{{$slider->slider_desc}}</td>
                            <td>
                                <a href="{{URL::to('/edit-slider/'.$slider->slider_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này ko?')" href="{{URL::to('/delete-slider/'.$slider->slider_id)}}" class="active styling-edit" ui-toggle-class="">
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
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {!! $all_slider->links() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
