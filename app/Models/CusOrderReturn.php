<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CusOrderReturn extends Model
{
    protected $table = 'cusorderreturn';
    protected $primaryKey = 'cusRetID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['orderReturn_Date','reason', 'actionTaken'];
}
