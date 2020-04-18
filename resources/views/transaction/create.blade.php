@extends('layouts.app')

@section('content')

    Form for buying a book

    {{ Form::open(array('route' => 'transaction.store')) }}
        {{ Form::token() }}

        {{ Form::label('book', 'Choose a book') }}
        {{ Form::select('book', $books) }}

        {{ Form::submit('Buy this book') }}

    {{ Form::close() }}

@endsection

