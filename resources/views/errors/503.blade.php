@extends('layouts.app')

@section('title', '503 — Temporarily unavailable · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="503"
        eyebrow="TEMPORARILY UNAVAILABLE"
        heading="Taking a quick breather."
        message="This page is temporarily unavailable. Please come back in a little while."
    />
@endsection
