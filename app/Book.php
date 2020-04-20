<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function available()
    {
        return $this->stock - $this->reservations()->count();
    }
}
