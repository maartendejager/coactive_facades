<?php


namespace App\Bookstore\StockManager;


use App\Book;
use App\Reservation;
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
     * Reserve a book if it is in stock
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
    public function unReserveBook(Reservation $reservation)
    {
        $reservation->delete();
    }

    /**
     * Reserved book is sold:
     * Update stock and delete reservation
     */
    public function sellReservedBook(Reservation $reservation)
    {
        $reservation->book()->stock--;

        $this->unReserveBook($reservation);
    }
}
