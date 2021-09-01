@extends('errors::errorbase')

@section('title', __('Forbidden'))
@section('heading', __("We are sorry...") )
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('image', url('/assets/error/403.png') )