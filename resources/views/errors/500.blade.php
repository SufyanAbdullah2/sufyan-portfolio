@extends('layouts.app')

@section('title', '500 — Something went wrong · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="500"
        eyebrow="INTERNAL SERVER ERROR"
        heading="Something went a little sideways."
        message="The page couldn’t load just now. Please try again in a moment."
    />
@endsection
