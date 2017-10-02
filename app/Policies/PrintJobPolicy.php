<?php

namespace App\Policies;

use App\Models\Patron;
use App\Models\PrintJob;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrintJobPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the print job.
     *
     * @param  \App\Models\Patron  $patron
     * @param  \App\Models\PrintJob  $printJob
     * @return mixed
     */
    public function view(Patron $patron, PrintJob $printJob)
    {
        return $patron->id === $printJob->patron;
    }

}
