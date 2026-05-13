@extends('layouts.app')

@section('header', 'Domains')

@section('content')

    <div id="domains-table">
        @include('domains.partials.async-table')
    </div>

@endsection
