<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Notification extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'display_name', 'subject', 'message', 'department',
    ];
}
