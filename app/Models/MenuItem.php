<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menuitem';
    protected $primaryKey = 'menuID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['itemName', 'category', 'size', 'price', 'availability', 'image'];
}
