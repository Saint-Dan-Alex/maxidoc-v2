@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', "Accès refusé - Vous n'avez pas les droits nécessaires pour accéder à cette page.")
