<?php


namespace App\Bookstore\InvoiceManager;


use App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;

class InvoiceManager
{

    protected $financialInstitution;
    protected $book;
    /**
     * InvoiceManager constructor.
     */
    public function __construct(FinancialInstitution $financialInstitution, Book $book)
    {
        $this->financialInstitution = $financialInstitution;
        $this->book = $book;
    }

    public function generate()
    {
        return "You bought $this->book for $this->financialInstitution->price.";
    }
}
