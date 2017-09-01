<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Status extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = ['name', 'accept_payment', 'dashboard_display'];

}
