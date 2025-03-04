<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder_ExtraTopping extends Model
{
    protected $table = 'customerorder_extratopping';
    protected $primaryKey = ['orderID', 'menuID', 'toppingID']; // Composite key    
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['orderID','menuID', 'toppingID'];

    //function to make composite keys work
    public function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }    
}
