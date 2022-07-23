<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shipping extends Model
{
    protected $table = "tbl_shipping";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'shipping_id',
        'shipping_name',
        'shipping_email',
        'shipping_address',
        'shipping_phone',
        'shipping_note',
        'shipping_method',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
