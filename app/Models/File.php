<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'print_job_id', 'original_filename', 'filename',
    ];
}
