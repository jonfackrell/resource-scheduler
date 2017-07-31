<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{

    public function getOptionsAttribute()
    {
        return json_decode( $this->attributes['options'] );
    }

    public function setOptionsAttribute( $val )
    {
        $this->attributes['options'] = json_encode( $val );
    }

}
