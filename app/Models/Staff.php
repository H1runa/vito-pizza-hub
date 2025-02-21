<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staffID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['firstName', 'lastName', 'jobTitle', 'DOB', 'NIC', 'addressLine1', 'addressLine2', 'addressLine3', 'servChargeID'];

}
