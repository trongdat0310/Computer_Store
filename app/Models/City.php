<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class City extends Model
{
    protected $table = "tbl_tinhthanhpho";
    public $timestamps = true;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'city_id',
        'city_name',
        'type',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
