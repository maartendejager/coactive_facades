<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transaction;
use App\PaymentProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Bookstore\StockManager\StockManager;
use App\Bookstore\InvoiceManager\InvoiceManager;
use App\Bookstore\PaymentManager\PaymentManager;
use App\Bookstore\PaymentManager\Services\InstitutionService;

class TransactionController extends Controller
{
    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alert = session('alert');
        $books = Book::all();
        $banks = PaymentProvider::all();

        return view('transaction.create', compact('books', 'banks', 'alert'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::find($request->book);
        $bank = $request->bank;

        // Reserve the book if it is in stock
        $stockManager = new StockManager();
        $reservation = $stockManager->reserveBook($book, Auth::user());

        if (!$reservation) {
            session()->flash('alert', 'Sorry, this book is not in stock!');

            return redirect()->back();
        }

        // Make payment
        $financialInstitution = InstitutionService::findPaymentInstitutionByName($bank);
        $paymentManager = new PaymentManager($book, $financialInstitution);

        if (!$paymentManager->payForBook()) {
            $stockManager->clearReservation($reservation);

            session()->flash('alert', 'Sorry, your payment failed!');
            return redirect()->back();
        }

        // Update Stock
        $transaction = $stockManager->sellReservedBook($reservation);


        // Generate Invoice
        $invoiceManager = new InvoiceManager($paymentManager, $transaction);
        $transaction->invoice = $invoiceManager->generate();
        $transaction->save();

        return Redirect::route('transaction.show', $transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $invoice = $transaction->invoice;

        return view('transaction.show', compact('invoice'));
    }


}
