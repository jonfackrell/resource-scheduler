<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];


    /**
     * The filaaments that a department has.
     */
    public function filaments()
    {
        return $this->belongsToMany('App\Models\Filament', 'departments_filaments', 'department', 'filament');
    }
    
}
