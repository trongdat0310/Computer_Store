<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Shipping;
use App\Models\Feeship;
use PDF;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function manager_order(){
        $order = Order::query()
            ->orderBy('created_at','DESC')
            ->get();
        return view('admin.manager_order')
            ->with(compact('order'));
    }

    public function details_order($order_code){
        $details_order = Order_details::query()
            ->where('order_code', $order_code)
            ->get();
        $order = Order::query()
            ->where('order_code', $order_code)
            ->first();
        if ($order->coupon_code != 'no'){
            $coupon_condition = $order->coupon->coupon_condition;
            $coupon_number = $order->coupon->coupon_number;
        }else{
            $coupon_condition = 0;
            $coupon_number = 0;
        }

        return view('admin.view_order')
            ->with(compact(
                'details_order',
                'order',
                'coupon_condition',
                'coupon_number'
            ));
    }

    public function print_order($checkout_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }

    public function print_order_convert($checkout_code){
        $details_order = Order_details::query()
            ->where('order_code', $checkout_code)
            ->get();
        $order = Order::query()
            ->where('order_code', $checkout_code)
            ->first();

        $output = '';

        $output .= '
            <style>
                body{
                    font-family: DejaVu Sans;
                }
                table {
                  border-collapse: collapse;
                  width: 100%;
                }

                td, th {
                  border: 1px solid #000000;
                  text-align: left;
                  padding: 8px;
                }

            </style>
            <h1 style="text-align: center">Công ty TNHH một mình tao</h1>
            <h4 style="text-align: center">Độc Lập - Tự Do - Hạnh Phúc</h4>
            <p>Người đặt hàng</p>
            <table>
                <thead>
                    <tr>
                        <th>Tên khách đặt</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $output .= '
            <tr>
                <td>'.$order->customer->customer_name.'</td>
                <td>'.$order->customer->customer_phone.'</td>
                <td>'.$order->customer->customer_email.'</td>
            </tr>
        ';

        $output .= '
                </tbody>
            </table>
            <p>Người nhận hàng</p>
            <table>
                <thead>
                    <tr>
                        <th>Tên khách đặt</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
        ';
            $output .= '
            <tr>
                <td>'.$order->shipping->shipping_name.'</td>
                <td>'.$order->shipping->shipping_address.'</td>
                <td>'.$order->shipping->shipping_phone.'</td>
                <td>'.$order->shipping->shipping_email.'</td>
                <td>'.$order->shipping->shipping_note.'</td>
            </tr>
        ';


        $output .= '
                </tbody>
            </table>
            <p>Đơn hàng</p>
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $total = 0;
        foreach ($details_order as $details_orders){
            foreach ($details_orders->product as $products)
                $sub_total = $details_orders->product_sales_quantity*$products->product_price;
                $total += $sub_total;
            $output .= '
                <tr>
                    <td>'.$products->product_name.'</td>
                    <td>'.$details_orders->product_sales_quantity.'</td>
                    <td>'.number_format($products->product_price,0,',','.').'</td>
                    <td>'.number_format($sub_total,0,',','.').'</td>
                </tr>
            ';
        }

        if ($order->coupon_code != 'no'){
            $coupon_condition = $order->coupon->coupon_condition;
            $coupon_number = $order->coupon->coupon_number;
            $name_condition = $order->coupon->coupon_name;
            if ($coupon_condition == 1){
                $total_discount = $total*$coupon_number/100;
            }if ($coupon_condition == 2) {
                $total_discount = $total - $coupon_number;
            }
        }else{
            $coupon_condition = 0;
            $coupon_number = 0;
            $name_condition = 'Không có mã giảm giá';
            $total_discount = 0;
        }

        $output .= '
                    <tr>
                        <td colspan="4">
                            <p>Tổng tiền hàng: '.number_format($total,0,',','.').'đ</p>
                            <p>Phí ship: '.number_format($order->order_fee,0,',','.').'đ</p>
                            <p>Mã giảm giá: '.$name_condition.'</p>
                            <p>Tổng giảm: '.number_format($total_discount,0,',','.').'đ</p>
                            <p>Tổng thanh toán: '.number_format($total + $order->order_fee - $total_discount,0,',','.').'đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p>Kí tên</p>
            <table>
                <thead>
                    <tr>
                        <th>Người nhận</th>
                        <th>Ký tên</th>
                    </tr>
                </thead>
                <tbody>
            <tr>
                <td>'.$order->shipping->shipping_name.'</td>
                <td></td>
            </tr>
                </tbody>
            </table>
        ';
        return $output;
    }
}
