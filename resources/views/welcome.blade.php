@extends('layouts.app')

@section('content')
    <div class="container w-100 h-100">
        <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <div class="pb-4">
                @php
                    $space = $name ? ' ' : '';
                @endphp
                <h1 class="display-1">Welcome{{$space}}{{ $name }}!</h1>
            </div>
        </div>
    </div>
@endsection

