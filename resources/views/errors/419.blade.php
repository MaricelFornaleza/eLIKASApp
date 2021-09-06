@extends('errors::errorbase')

@section('title', __('Page Expired'))
@section('heading', __("Oops...") )
@section('code', '419')
@section('message', __('Try to login again.'))
@section('image', url('/assets/error/419.png') )