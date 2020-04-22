@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row pt-5">
            <div class="col">
                <h1 class="display-3 pb-3">Thanks, here is your invoice:</h1>

                <h3 class="pt-3">{{ $invoice }}</h3>
            </div>
        </div>

    </div>

@endsection
