<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOffer extends Model
{
    protected $table = 'customeroffer';
    protected $primaryKey = 'OfferID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['offerName', 'offerRate', 'description'];
}
