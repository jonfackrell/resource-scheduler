<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patron extends Authenticatable
{

    use Notifiable;
    //

    protected $fillable = [
        'first_name', 'last_name', 'email', 'department'
    ];

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
	}


}
