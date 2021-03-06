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
                                <h4 class="card-title text-truncate"> {{ $book->title }} </h4>
                                <p class="card-text d-none"> {{ Str::limit($book->description, 80) }} ... </p>
                                <h5><strong>price: €{{ $book->price  }}</strong></h5>
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
                        <label for="bank">Choose your bank</label>
                        <select id="bank" name="bank" class="form-control">
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
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
