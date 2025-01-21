@extends('emails.email')

@section('content')
    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h1>Hallo, {{ $customer->name }}</h1>

        @foreach ($images as $imagePath)
            <img src="{{ $message->embed(Storage::disk('temporary')->path($imagePath)) }}" alt="Image"
                style="max-width: 100%; height: auto;">
        @endforeach

        <p>{{ $content }}</p>
        <p>Mit freundlichen Grüßen,<br>Ihr Habaneando-Team</p>
    </div>
@endsection
