<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Slider extends Model
{
    protected $table = "tbl_slider";
    public $timestamps = true;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'slider_id',
        'slider_name',
        'slider_image',
        'slider_status',
        'slider_desc',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
