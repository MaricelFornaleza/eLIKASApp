@extends('errors::errorbase')

@section('title', __("Page Unavailable"))
@section('heading', __("Hmm... We have a problem.") )
@section('code', '500')
@section('message', "The page that you are looking for is temporarily unavailable." )
@section('image', url('/assets/error/404.png') )