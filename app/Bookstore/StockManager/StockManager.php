<?php


namespace App\Bookstore\StockManager;


use App\Book;
use App\Reservation;
use App\Transaction;
use App\User;

class StockManager
{
    /**
     * Check if a book is in stock
     */
    public function bookIsInStock(Book $book)
    {
        $booksInStock = $book->stock;
        $reservations = $book->reservations->count();

        $availableBooks = $booksInStock - $reservations;

        return (bool)($availableBooks > 0);
    }

    /**
     * Reserve a book
     */
    public function reserveBook(Book $book, User $user = null)
    {
        if (!$this->bookIsInStock($book)) {
            return false;
        }

        $reservation = Reservation::create([
            'user' => $user,
            'book' => $book
        ]);

        return $reservation;
    }

    /**
     * Remove a reservation
     */
    public function clearReservation(Reservation $reservation)
    {
        $reservation->delete();
    }

    /**
     * Reserved book is sold:
     * Update stock and delete reservation
     */
    public function sellReservedBook(Reservation $reservation)
    {
        $book = $reservation->book;
        $user = $reservation->user;

        $book->stock--;
        $book->save();

        $transaction = new Transaction([
            'user' => $user,
            'book' => $book,
            'price' => $book->price
        ]);

        $this->clearReservation($reservation);

        return $transaction;
    }
}

