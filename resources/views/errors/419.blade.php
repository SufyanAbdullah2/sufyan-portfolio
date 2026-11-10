@extends('layouts.app')

@section('title', '419 — Page expired · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="419"
        eyebrow="PAGE EXPIRED"
        heading="That page got a little stale."
        message="Your session may have expired. Head back and give it another try."
    />
@endsection
