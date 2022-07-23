<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    protected $table = "tbl_admin";
    public $timestamps = true;
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'admin_id',
        'admin_email',
        'admin_password',
        'admin_name',
        'admin_phone'
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
