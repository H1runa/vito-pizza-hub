<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffOvertimeAllowance extends Model
{
    protected $table = 'staffovertimeallowance';
    protected $primaryKey = 'OTID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['date', 'hour', 'amount', 'staffID'];
}
