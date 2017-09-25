<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Status extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = ['name', 'accept_payment', 'dashboard_display', 'can_delete', 'in_queue', 'notification', 'subtract_inventory', 'completed'];

    /**
     * The notification class to send.
     */
    public function systemNotification()
    {
        return $this->hasOne(Notification::class, 'id', 'notification');
    }

}
