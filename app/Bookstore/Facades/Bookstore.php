<?php


namespace App\Bookstore\Facades;


use App\Book;
use App\Bookstore\InvoiceManager\InvoiceManager;
use App\Bookstore\PaymentManager\PaymentManager;
use App\Bookstore\PaymentManager\Services\InstitutionService;
use App\Bookstore\StockManager\StockManager;
use Illuminate\Support\Facades\Auth;

class Bookstore
{
    private $bank;
    public $transaction;
    /**
     * @var string
     */
    public $message;

    /**
     * Bookstore constructor.
     */
    public function __construct($bank)
    {
        $this->bank = $bank;
    }

    public function sellBook(Book $book)
    {
        // Reserve the book if it is in stock
        $stockManager = new StockManager();

        $reservation = $this->createReservation($book);


        // Make payment
        $financialInstitution = InstitutionService::findPaymentInstitutionByName($this->bank);
        $paymentManager = new PaymentManager($book, $financialInstitution);

        if (!$paymentManager->payForBook()) {
            $stockManager->clearReservation($reservation);
            $this->message = 'Sorry, your payment failed!';

            return false;
        }

        // Update Stock
        $transaction = $stockManager->sellReservedBook($reservation);

        // Generate Invoice
        $invoiceManager = new InvoiceManager($paymentManager, $transaction);
        $transaction->invoice = $invoiceManager->generate();
        $transaction->save();

        $this->transaction = $transaction;

        return true;
    }

    public function createReservation($book)
    {


    }
}
