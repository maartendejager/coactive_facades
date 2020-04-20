<?php


namespace App\Bookstore\InvoiceManager;

use App\Book;
use App\Transaction;
use App\Bookstore\PaymentManager\PaymentManager;

class InvoiceManager
{

    protected $paymentManager;
    protected $transaction;
    /**
     * InvoiceManager constructor.
     */
    public function __construct(PaymentManager $paymentManager, Transaction $transaction)
    {
        $this->paymentManager = $paymentManager;
        $this->transaction = $transaction;
    }

    public function generate()
    {
        $price =  $this->paymentManager->getPrice();
        $booktitle = $this->transaction->book->title;


        return "You bought $booktitle for $price.";
    }
}
