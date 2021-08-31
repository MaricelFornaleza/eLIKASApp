@extends('errors::errorbase')

@section('title', __('Unauthorized'))
@section('heading', __("We are sorry...") )
@section('code', '401')
@section('message', __('You are unauthorized to access this page.'))
@section('image', url('/assets/error/403.png') )