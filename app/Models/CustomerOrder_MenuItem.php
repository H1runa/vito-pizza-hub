<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder_MenuItem extends Model
{
    protected $table = 'customerorder_menuitem';
    protected $primaryKey = ['orderID', 'menuID']; // Composite key    
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['orderID','menuID', 'quantity'];

    //function to make composite keys work
    public function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }    
}
