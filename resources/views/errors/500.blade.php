@extends('errors::minimal')

@section('title', __('Erreur serveur'))
@section('code', '500')
@section('message', __('Erreur serveur'))
@section('paragraph', __("Une erreur s'est produite au niveau du serveur, veuillez cliquer sur le bouton actualiser pour se connecter"))
@section('btn-action')
    <a href="/" class="btn btn-add btn-add-hover">Actualiser</a>
@endsection
