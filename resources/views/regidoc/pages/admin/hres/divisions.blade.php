@extends('layouts.app')

@section('search')
    @livewire('search-division')
@endsection
@section('content')

    @livewire('humanres.division.show-division')
@include('components.humanres.modals.division')
@endsection

