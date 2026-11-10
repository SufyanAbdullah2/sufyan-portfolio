@extends('layouts.app')

@section('title', '429 — Slow down a moment · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="429"
        eyebrow="TOO MANY REQUESTS"
        heading="One moment — let’s catch our breath."
        message="There have been a few too many requests. Please wait a little before trying again."
    />
@endsection
