<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transaction;
use App\PaymentProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Bookstore\StockManager\StockManager;
use App\Bookstore\InvoiceManager\InvoiceManager;
use App\Bookstore\PaymentManager\PaymentManager;
use App\Bookstore\PaymentManager\Providers\Bunq;
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
        $paymentmanagers = PaymentProvider::all();

        return view('transaction.create', compact('books', 'paymentmanagers', 'alert'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::find($request->book);

        // Reserve the book if it is in stock
        $stockManger = new StockManager();
        $reservation = $stockManger->reserveBook($book, Auth::user());

        if (!$reservation) {
            session()->flash('alert', 'Sorry, this book is not in stock!');

            return redirect()->back();
        }

        // Make payment
        $financialInstitution = InstitutionService::findPaymentInstitutionByName($request->paymentmanager);
        $paymentManager = new PaymentManager($book, $financialInstitution);

        if (!$paymentManager->payForBook()) {
            $stockManger->clearReservation($reservation);
            session()->flash('alert', 'Sorry, your payment failed!');

            return redirect()->back();
        }

        // Update Stock
        $transaction = $stockManger->sellReservedBook($reservation);

        // Generate Invoice
        $invoiceManager = new InvoiceManager($paymentManager, $transaction);
        $transaction->invoice = $invoiceManager->generate();
        $transaction->save();

        return redirect()->route('transaction.show', $transaction);

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
