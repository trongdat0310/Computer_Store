<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    protected $table = "tbl_customer";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_password',
        'customer_phone',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
