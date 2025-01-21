@extends('emails.email')

@section('content')
    <h1>Hallo, {{ $customer->name }}</h1>
    <p>{{ $content }}</p>
    <p>Mit freundlichen Grüßen,<br> Ihr Habaneando-Team</p>
@endsection
