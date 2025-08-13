@extends('errors::minimal')

@section('title', __('Page expirée'))
@section('code', '419')
@section('message', "Votre session a expiré en raison d'une inactivité prolongée. Veuillez rafraîchir la page et vous reconnecter. Si le problème persiste, contactez l'administrateur du système.")
