<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceChargeAllowance extends Model
{
    protected $table = 'servicechargeallowance';
    protected $primaryKey = 'servChargeID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['date', 'amount'];

    
}
