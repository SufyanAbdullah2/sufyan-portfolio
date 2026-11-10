@extends('layouts.app')

@section('title', '401 — Sign in required · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="401"
        eyebrow="SIGN IN REQUIRED"
        heading="This space needs a sign-in."
        message="Please sign in with an authorized account to continue."
    />
@endsection
