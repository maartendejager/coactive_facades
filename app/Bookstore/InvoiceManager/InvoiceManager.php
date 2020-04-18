<?php


namespace App\Bookstore\InvoiceManager;


use App\Bookstore\PaymentManager\Interfaces\Payment;

class InvoiceManager
{

    protected $payment;
    protected $book;
    /**
     * InvoiceManager constructor.
     */
    public function __construct(Payment $payment, Book $book)
    {
        $this->payment = $payment;
        $this->book = $book;
    }

    public function generate()
    {
        return "You bought $this->book for $this->payment->price.";
    }
}
