<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'staffsalary';
    protected $primaryKey = 'salaryID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['baseSalary', 'fixedAllowance', 'netSalary', 'dateIssued', 'staffID', 'servChargeID', 'OTID', 'EPFID', 'ETFID'];
}
