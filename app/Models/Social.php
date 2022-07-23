<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'tbl_social';
    public $timestamps = true;
    protected $fillable = [
        'provider_user_id',
        'provider',
        'user'
    ];

    protected $primaryKey = 'user_id';

    public function login(){
        return $this->belongsTo('App\Models\Admin', 'user');
    }

}
