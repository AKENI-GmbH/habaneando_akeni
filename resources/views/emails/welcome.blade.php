@extends('emails.email')

@section('content')
    <p>Hallo {{ $customerName }},</p>
    <p>Willkommen bei Salsa Tanzschule Habaneando!</p>
    <p>Wir freuen uns, Sie bei unserer Salsa Tanzschule begrüßen zu dürfen!</p>
    <p>Danke für Ihre Anmeldung und viel Spaß beim Tanzen!</p>
    <p>Mit freundlichen Grüßen,<br>
        Ihr Habaneando-Team</p>
@endsection
