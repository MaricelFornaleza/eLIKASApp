@extends('errors::errorbase')

@section('title', __("Service Unavailable"))
@section('heading', __("Hmm... We have a problem.") )
@section('code', '503')
@section('message', "The service is temporarily unavailable." )
@section('image', url('/assets/error/404.png') )