<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transaction;
use App\PaymentProvider;
use Illuminate\Http\Request;
use App\Bookstore\Facades\Bookstore;
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

        // Make payment

        // Update Stock

        // Generate Invoice

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
