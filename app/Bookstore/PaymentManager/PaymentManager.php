<?php


namespace App\Bookstore\PaymentManager;


use App\Book;
use App\Bookstore\PaymentManager\Interfaces\Payment;

class PaymentManager
{
    private $book;
    private $payment;

    public function __construct(Book $book, Payment $payment)
    {
        $this->book = $book;
        $this->payment = $payment;
    }

    public function payForBook(Book $book)
    {
        if (!$this->payment->authorizeAccount()) {
            return false;
        }

        return $this->payment->executePayment($this->book->price);
    }

}
