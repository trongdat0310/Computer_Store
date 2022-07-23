<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;

use Illuminate\Http\Request;

session_start();

class DeliveryController extends Controller
{
    public function delivery(Request $request){
        $city = City::query()
            ->orderBy('city_id','ASC')
            ->get();
        return view('admin.fee.add_delivery')
            ->with(compact(
                'city'
            ));
    }

    public function select_delivery(Request $request){
        $data = $request->all();
        if ($data['action']){
            $output = '';
            if ($data['action'] == 'city'){
                $select_province = Province::query()
                    ->where('city_id',$data['ma_id'])
                    ->orderBy('province_id','ASC')
                    ->get();
                $output .= '
                    <option value="0">---Chọn Quận Huyện---</option>
                    ';
                foreach ($select_province as $province){
                    $output .= '
                    <option value="'.$province->province_id.'">'.$province->province_name.'</option>
                    ';
                }
            }elseif($data['action'] == 'province'){
                $select_wards = Wards::query()
                    ->where('province_id',$data['ma_id'])
                    ->orderBy('wards_id','ASC')
                    ->get();
                $output .= '
                    <option value="0">---Chọn Xã Phường---</option>
                    ';
                foreach ($select_wards as $wards){
                    $output .= '<option value="'.$wards->wards_id.'">'.$wards->wards_name.'</option>';
                }
            }
            echo $output;
        }
    }

    public function insert_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->city_id = $data['city'];
        $fee_ship->province_id = $data['province'];
        $fee_ship->wards_id = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }

    public function select_feeship(){
        $feeship = Feeship::query()
        ->orderBy('fee_id','DESC')
        ->get();
        $output = '';
        $output .=
        '<div class="table-responsive">
			<table class="table table-bordered">
				<thread>
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th>
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>
				</thread>
				<tbody>
				';

        foreach($feeship as $feeships){
            $output.=
                '
					<tr>
						<td>'.$feeships->city->city_name.'</td>
						<td>'.$feeships->province->province_name.'</td>
						<td>'.$feeships->wards->wards_name.'</td>
						<td contenteditable data-feeship_id="'.$feeships->fee_id.'" class="fee_feeship_edit">'.number_format($feeships->fee_feeship,0,',','.').'</td>
					</tr>
                ';
        }

        $output.='
				</tbody>
			</table>
        </div>
				';
        echo $output;
    }

    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::query()
        ->find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
