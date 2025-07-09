@extends('regidoc.layouts.master')
@section('content')
    <div class="container-fluid px-lg-4">
        <a href="javascript:history.go(-1)" class="back">
            <i class="fi fi-rr-angle-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a>
        <div class="row g-lg-3">
            @livewire('archivage.document', ['dossier' => $dossier])
        </div>
    </div>

    {{-- @include('components.admin.modals.archive-document', ['dossier' => $dossier]) --}}
@endsection
