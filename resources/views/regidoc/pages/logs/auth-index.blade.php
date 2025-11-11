@extends('regidoc.layouts.master')

@section('content')
<div class="container-fluid py-3">
    <div class="card">
        <div class="card-body">
            @livewire('admin.logs.authentication-logs-index')
        </div>
    </div>
</div>
@endsection
