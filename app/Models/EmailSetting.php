<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EmailSetting extends Model
{

    /**
     * The model table.
     *
     * @var array
     */
    protected $table = 'email_settings';

    /**
     * Primary key
     *
     * @var array
     */
    protected $primaryKey  = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'incoming_host', 'incoming_port', 'outgoing_host', 'outgoing_port', 'from_address', 'from_name', 'encryption', 'username', 'password', 'enabled',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Set the email password.
     *
     * @param  string  $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encrypt($value);
    }

    /**
     * Get the email password.
     *
     * @param  string  $value
     * @return string
     */
    public function getPasswordAttribute($value)
    {
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return '';
        }
    }
}
