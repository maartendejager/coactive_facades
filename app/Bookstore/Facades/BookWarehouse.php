<?php


namespace App\Bookstore\Facades;


use App\Book;
use App\Bookstore\InvoiceManager\InvoiceManager;
use App\Bookstore\PaymentManager\PaymentManager;
use App\Bookstore\PaymentManager\Services\InstitutionService;
use App\Bookstore\StockManager\StockManager;

class BookWarehouse
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
     * Bookstore constructor.
     */
    public function __construct($bank)
    {
        $this->bank = $bank;

        $this->stockManager = new StockManager();
    }

    public function sellBook(Book $book)
    {
        $user = Auth::user();
        $company = $user->company;

        // Reserve a book for each student
        // If there are not enough books, pre-reserve them.
        foreach ($company->subscriptions as $student) {
            $reservation = $this->stockManager->reserveBook($book, $student, true);

            $transaction = $this->stockManager->sellReservedBook($reservation);
        }

        // Generate Invoice
        $financialInstitution = InstitutionService::findPaymentInstitutionByName($this->bank);
        $paymentManager = new PaymentManager($book, $financialInstitution);

        $invoiceManager = new InvoiceManager($paymentManager, $transaction);
        $transaction->invoice = $invoiceManager->generate();
        $transaction->save();

        $this->transaction = $transaction;

        return true;
    }

}
