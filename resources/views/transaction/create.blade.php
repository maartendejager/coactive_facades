@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Buy one of our books!</h1>

                <div class="card-group w-50">
                    @foreach($books as $book)
                        <div class="card mr-3">
                            <img class="card-img-top p-3" src="/img/books/{{ $book->image }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title text-truncate"> {{ $book->title }} </h5>
                                <p class="card-text"> {{ Str::limit($book->description, 80) }} ... </p>
                                <p><strong>price: €{{ $book->price  }}</strong></p>
                            </div>
                            <div class="card-footer">
                                <p class="card-text"> <strong>Stock: {{ $book->available() }}</strong> <small class="text-muted float-right"> ISBN: {{ $book->ISBN }} </small></p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col">

                @if (isset($alert))
                    <div class="alert alert-danger" role="alert">
                        {{ $alert }}
                    </div>
                @endif

                <form method="POST" action="http://coactive_facades.test/transaction" accept-charset="UTF-8">
                    @csrf

                    <div class="form-group">
                        <label for="book">Choose a book</label>
                        <select id="book" name="book" class="form-control">
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="paymentmanager">Choose your bank</label>
                        <select id="paymentmanager" name="paymentmanager" class="form-control">
                            @foreach($paymentmanagers as $paymentmanager)
                                <option value="{{ $paymentmanager->id }}">{{ $paymentmanager->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary mb-2" type="submit" value="Buy this book">
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
