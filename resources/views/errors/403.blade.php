@extends('layouts.app')

@section('title', '403 — Access denied · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="403"
        eyebrow="ACCESS DENIED"
        heading="This space is private."
        message="You don’t have permission to view this page. Let’s get you back somewhere familiar."
    />
@endsection
