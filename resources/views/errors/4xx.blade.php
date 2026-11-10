@extends('layouts.app')

@section('title', 'Request error · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        :code="$exception->getStatusCode()"
        eyebrow="REQUEST ERROR"
        heading="That request didn’t quite work."
        message="Something about this request wasn’t quite right. Head back home and try again."
    />
@endsection
