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
                    </div
                @endif
                {{ Form::open(array('route' => 'transaction.store')) }}

                <div class="form-group">
                    {{ Form::label('book', 'Choose a book') }}
                    {{ Form::select('book', $bookselect, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('paymentmanager', 'Choose your bank') }}
                    {{ Form::select('paymentmanager', $paymentmanagers) }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Buy this book', ['class' => 'btn btn-primary mb-2']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>





    </div>



@endsection

