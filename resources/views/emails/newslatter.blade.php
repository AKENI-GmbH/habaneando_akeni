@extends('emails.email')

@section('content')
    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h1>Hallo, {{ $customer->name }}</h1>
        <img src="{{ $src }}" alt="Image" style="max-width: 100%; height: auto;">
        <p>{{ $content }}</p>
        <p>Mit freundlichen Grüßen,<br>Ihr Habaneando-Team</p>
    </div>
@endsection
