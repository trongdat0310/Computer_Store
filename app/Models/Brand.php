<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Brand extends Model
{
    protected $table = "tbl_brand_product";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'brand_id',
        'brand_name',
        'brand_desc',
        'brand_status',
        'meta_keyword',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];


}
