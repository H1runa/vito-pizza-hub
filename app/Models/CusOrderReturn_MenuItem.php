<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CusOrderReturn_MenuItem extends Model
{
    protected $table = 'cusorderreturn_menuitem';
    protected $primaryKey = ['cusRetID', 'menuID']; // Composite key    
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['cusRetID','menuID'];

    //function to make composite keys work
    public function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }    
}
