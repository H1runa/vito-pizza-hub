<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EPF extends Model
{
    protected $table = 'epf_contribution';
    protected $primaryKey = 'EPFID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['date', 'EPF_rate', 'amount', 'staffID'];
}
