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
        $bookselect = Book::pluck('title', 'id')->all();
        $paymentmanagers = PaymentProvider::pluck('name', 'id')->all();
        return view('transaction.create', compact('books', 'bookselect', 'paymentmanagers', 'alert'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::find($request->book);

        // Check if the book is in stock and reserve the book
        $stockManger = new StockManager();
        if (!$stockManger->bookIsInStock($book)) {
            session()->flash('alert', 'Sorry, this book is not in stock!');

            return redirect()->route('transaction.create');
        }

        $reservation = $stockManger->reserveBook($book, Auth::user());

        // Make payment
        $financialInstitution = InstitutionService::findPaymentInstitutionByName($request->paymentmanager);
        $paymentManager = new PaymentManager($book, $financialInstitution);


        if (!$paymentManager->payForBook()) {
            session()->flash('alert', 'Sorry, your payment failed!');

            return redirect()->route('transaction.create');
        }
        return 'here';

        // Update Stock
        $stockManger->sellReservedBook($reservation);

        // Generate Invoice

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }


}
