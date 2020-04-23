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
     * @var StockManager
     */
    private $stockManager;

    /**
     * @var \App\Bookstore\PaymentManager\Providers\Bunq|\App\Bookstore\PaymentManager\Providers\Ing|\App\Bookstore\PaymentManager\Providers\Triodos
     */
    private $financialInstitution;

    /**
     * @var Book
     */
    private $book;
    /**
     * @var PaymentManager
     */
    private $paymentManager;

    /**
     * Bookstore constructor.
     */
    public function __construct($bank, Book $book)
    {
        $this->bank = $bank;
        $this->book = $book;

        $this->stockManager = new StockManager();
        $this->financialInstitution = InstitutionService::findPaymentInstitutionByName($this->bank);
        $this->paymentManager = new PaymentManager($this->book, $this->financialInstitution);
    }

    public function sellBook()
    {
        // Reserve the book if it is in stock
        $reservation = $this->stockManager->reserveBook($this->book, Auth::user());
        if (!$reservation) {
            $this->message = 'Sorry, this book is not in stock!';

            return false;
        }

        // Make payment
        if (!$this->paymentManager->payForBook()) {
            $this->stockManager->clearReservation($reservation);

            $this->message = 'Sorry, your payment failed!';

            return false;
        }

        // Update Stock
        $transaction = $this->stockManager->sellReservedBook($reservation);

        // Generate Receipt
        $invoiceManager = new InvoiceManager($this->paymentManager, $transaction);
        $transaction->invoice = $invoiceManager->generate();

        $transaction->save();

        $this->transaction = $transaction;

        return true;
    }
}
