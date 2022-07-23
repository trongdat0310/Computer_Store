<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Province extends Model
{
    protected $table = "tbl_quanhuyen";
    public $timestamps = true;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'province_id',
        'province_name',
        'type',
        'city_id',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
