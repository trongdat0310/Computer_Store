<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected $table = "tbl_feeship";
    protected $primaryKey = "fee_id";

    protected $fillable = [
        'city_id',
        'province_id',
        'wards_id',
        'fee_feeship',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function city(){
        return $this->belongsTo(City::class,'city_id','city_id');
    }
    public function province(){
        return $this->belongsTo(Province::class,'province_id','province_id');
    }
    public function wards(){
        return $this->belongsTo(Wards::class,'wards_id','wards_id');
    }
}
