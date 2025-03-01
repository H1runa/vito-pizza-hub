<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraTopping extends Model
{
    protected $table = 'extratopping';
    protected $primaryKey = 'toppingID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['toppingName', 'price', 'availablity'];
}
