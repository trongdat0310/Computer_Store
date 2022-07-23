<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    protected $table = "tbl_category_product";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'category_id',
        'category_name',
        'category_desc',
        'category_status',
        'meta_keyword',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
