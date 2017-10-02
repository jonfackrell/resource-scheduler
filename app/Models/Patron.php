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
        'first_name', 'last_name', 'email', 'department', 'netid', 'inumber'
    ];

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
	}

	public function sendDifferentFileNotification($token)
    {
        $this->notify(new sendDifferentFileNotification($token));
    }

    public function setInumberAttribute($value) {
        $this->attributes['inumber'] = str_replace('-', '', $value);
    }

    public function isSuperUser(){
        return in_array($this->attributes['email'], explode(',', env('SUPER')));
    }

}
