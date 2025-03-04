<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    protected $table = "systemuser";
    protected $primaryKey = 'staffID';
    public $incrementing = true;

    protected $keyType = "int";
    public $timestamps = false;
    protected $fillable = ['staffID','username', 'password'] ;

}
