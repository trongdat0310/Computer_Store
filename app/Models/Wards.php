<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Wards extends Model
{
    protected $table = "tbl_xaphuongthitran";
    public $timestamps = true;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'wards_id',
        'wards_name',
        'type',
        'province_id',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
