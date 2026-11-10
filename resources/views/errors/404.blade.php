@extends('layouts.app')

@section('title', '404 — Page not found · Sufyan®')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-error-page
        code="404"
        eyebrow="PAGE NOT FOUND"
        heading="Looks like this page took a detour."
        message="The link may have moved, or maybe it never existed. Either way, there’s good stuff waiting back home."
    />
@endsection
