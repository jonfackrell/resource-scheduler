<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{

    protected $fillable = [
        'subject', 'message', 'source', 'user', 'printjob'
    ];

    /**
     * Get the patron.
     */
    public function patron()
    {
        return $this->belongsTo(Patron::class, 'user', 'id');
    }

    /**
     * Get the employee.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
