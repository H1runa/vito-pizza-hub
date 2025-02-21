<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'dine_in_reservation';
    protected $primaryKey = 'resID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['reserveDate', 'reserveTime', 'staffID', 'cusID', 'tableID'];

    public function customer(){
        return $this->belongsTo(Customer::class, 'cusID', 'cusID');
    }
}
