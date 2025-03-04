<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CusOrderReturn_CustomerOrder extends Model
{
    protected $table = 'customerorder_cusorderreturn';
    protected $primaryKey = ['orderID', 'cusRetID']; // Composite key    
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['orderID','cusRetID', 'quantity'];

    //function to make composite keys work
    public function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }    
}
