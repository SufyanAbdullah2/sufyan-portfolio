@extends('layouts.app')

@section('title', 'Server error · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        :code="$exception->getStatusCode()"
        eyebrow="SERVER ERROR"
        heading="Something went a little sideways."
        message="This page couldn’t load just now. Please try again in a moment."
    />
@endsection
