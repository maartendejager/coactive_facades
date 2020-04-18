<?php

namespace App\Http\Controllers;

use App\Book;
use App\Bookstore\StockManager\StockManager;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::pluck('title', 'id')->all();
        return view('transaction.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::find($request->book);

        // Check if the book is in stock and reserve the book
        $stockManger = new StockManager();
        return $stockManger->bookIsInStock($book);

        // Make payment

        // Update Stock

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
