<?php


namespace App\Bookstore\PaymentManager;


use App\Book;
use App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;

class PaymentManager
{
    private $book;
    private $price;
    private $institution;

    public function __construct(Book $book, FinancialInstitution $payment)
    {
        $this->book = $book;
        $this->price = $this->book->price;
        $this->institution = $payment;
    }

    public function payForBook()
    {
        if (!$this->institution->authorizeAccount()) {
            return false;
        }

        return $this->institution->executePayment($this->price);
    }

    public function getPrice()
    {
        return $this->price;
    }

}
