<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DineTable extends Model
{
    protected $table = 'dinetable';
    protected $primaryKey = 'tableID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['seatCount', 'availability', 'staffID'];
}
