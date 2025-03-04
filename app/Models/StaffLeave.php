<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    protected $table = 'staff_leave';
    protected $primaryKey = 'leaveID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['leaveType', 'leaveDate', 'duration', 'reason', 'deductAmount', 'staffID', 'salaryID'];
}
