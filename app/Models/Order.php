<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    protected $table = "tbl_order";
    public $timestamps = true;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'order_id',
        'customer_id',
        'shipping_id',
        'order_status',
        'order_code',
        'coupon_code',
        'order_fee',
    ];

    public function customer(){
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }
    public function shipping(){
        return $this->hasOne(Shipping::class, 'shipping_id', 'shipping_id');
    }
    public function coupon(){
        return $this->hasOne(Coupon::class, 'coupon_code', 'coupon_code');
    }
}
