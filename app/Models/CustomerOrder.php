<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    protected $table = 'customerorder';
    protected $primaryKey = 'orderID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['orderType', 'orderDate', 'orderStatus', 'cusID', 'OfferID'];

    public function customer(){
        return $this->belongsTo(Customer::class, 'cusID', 'cusID');
    }

    public function menuItems(){
        return $this->belongsToMany(MenuItem::class, 'customerorder_menuitem', 'orderID', 'menuID')
                    ->withPivot('quantity');
    }

}
