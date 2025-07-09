@extends('errors::minimal')

@section('title', __('Page non trouvée'))
@section('code', '404')
@section('message', __('Oups ! Page non trouvée'))
@section('paragraph', __('La page que vous recherchez n\'a pu être trouvée. Veuillez cliquer sur le bouton "retour" pour revenir à la page d’accueil.'))
@section('btn-action')
    <a href="/" class="btn btn-add btn-add-hover">Retour</a>
@endsection
