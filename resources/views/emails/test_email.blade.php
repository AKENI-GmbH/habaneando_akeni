@extends('emails.email')

@section('content')
    <p>Hello, {{ $userName }},</p>
    <p>{{ $body }}</p>
    <p>{{ $closingMessage }}</p>
@endsection