@extends('regidoc.layouts.master')

@section('content')
<div class="container-fluid py-3">
    <a href="{{ route('regidoc.logs.auth.index') }}" class="btn btn-sm btn-light mb-3">&larr; Retour</a>
    <div class="card">
        <div class="card-body">
            @livewire('admin.logs.authentication-log-show', ['id' => $id])
        </div>
    </div>
</div>
@endsection
