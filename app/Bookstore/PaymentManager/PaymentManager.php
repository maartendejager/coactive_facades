<?php


namespace App\Bookstore\PaymentManager;


use App\Book;
use App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;

class PaymentManager
{
    private $book;
    private $institution;

    public function __construct(Book $book, FinancialInstitution $payment)
    {
        $this->book = $book;
        $this->institution = $payment;
    }

    public function payForBook()
    {
        if (!$this->institution->authorizeAccount()) {
            return false;
        }

        return $this->institution->executePayment($this->book->price);
    }

}
