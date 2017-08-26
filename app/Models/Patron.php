<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'department'
    ];

    public function fullName() {
    return $this->first_name . ' ' . $this->last_name;
	}

}
