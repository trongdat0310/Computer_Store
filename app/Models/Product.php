<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    protected $table = "tbl_product";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'product_id',
        'product_name',
        'product_quantity',
        'category_id',
        'brand_id',
        'product_desc',
        'product_content',
        'product_price',
        'product_image',
        'product_status',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function brand(){
        return $this->hasOne(Brand::class, 'brand_id', 'brand_id');
    }
    public function category(){
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
}
