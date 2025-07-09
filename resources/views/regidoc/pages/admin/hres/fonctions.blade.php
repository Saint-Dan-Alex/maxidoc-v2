@extends('layouts.app')
@section('search')
    @livewire('fonction')
@endsection
@section('content')

@livewire('humanres.fonction.show-fonction')
@include('components.humanres.modals.fonction')
@endsection

