<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ETF extends Model
{
    protected $table = 'etf_contribution';
    protected $primaryKey = 'ETFID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['date', 'ETF_rate', 'amount', 'staffID'];
}
