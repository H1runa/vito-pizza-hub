<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    protected $table = 'staffattendance';
    protected $primaryKey = 'attendID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['date', 'checkInTime', 'checkOutTime', 'attendanceStatus', 'staffID', 'leaveID'];
}
