<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function setUserAttribute(User $user)
    {
        $this->attributes['user_id'] = $user->getKey();
        $this->setRelation('user', $user);
    }

    public function setBookAttribute(Book $book)
    {
        $this->attributes['book_id'] = $book->getKey();
        $this->setRelation('book', $book);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
