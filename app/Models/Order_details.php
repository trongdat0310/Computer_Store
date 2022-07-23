<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order_details extends Model
{
    protected $table = "tbl_order_details";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'order_details_id',
        'order_code',
        'product_id',
        'product_sales_quantity',
        'product_coupon',
        'product_feeship',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function product(){
        return $this->hasMany(Product::class,'product_id', 'product_id');
    }
}
