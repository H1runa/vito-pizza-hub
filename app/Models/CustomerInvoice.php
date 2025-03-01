<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    protected $table = 'customerinvoice';
    protected $primaryKey = 'cusInvoiceID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['tax', 'discountAmount', 'serviceCharge', 'amount', 'totalBill', 'cusID', 'OfferID', 'orderID'];

    public function customerOrder(){
        return $this->belongsTo(CustomerOrder::class, 'orderID');
    }
}
