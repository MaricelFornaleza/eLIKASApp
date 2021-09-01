@extends('errors::errorbase')

@section('title', __("You're lost"))
@section('heading', __("Hmm... I wonder why did you land here somehow?") )
@section('code', '404')
@section('message', "The page that you are looking for is not found." )
@section('image', url('/assets/error/404.png') )