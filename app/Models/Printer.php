<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $fillable = ['name', 'description'];

public function departmentOwner()
    {
        return $this->belongsTo('App\Models\Department', 'department');
    }

}
