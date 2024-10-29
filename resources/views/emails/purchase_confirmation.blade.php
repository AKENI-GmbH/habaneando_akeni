@extends('emails.email')

@section('content')
    <p>Hallo {{ $subscription->customer->first_name }},</p>
    <p>Vielen Dank für Ihre Buchung bei Habaneando Salsa Tanzschule!</p>
    <p>Hier sind die Details Ihrer Buchung:</p>
    <ul>
        <li><strong>Name:</strong> {{ $subscription->customer->full_name }}</li>
        <li><strong>Bezeichnung:</strong> {{ $subscription->course->name }}</li>
        <li><strong>Preis:</strong> {{ number_format($subscription->amount, 2) }}€</li>
        <li><strong>Datum:</strong> {{ \Date::parse($subscription->course->start_date)->format('l j F Y') }} - {{ $subscription->course->schedule_time_from }} Uhr</li>
        <li><strong>Ort:</strong> {{ $subscription->course->location->address }}, {{ $subscription->course->location->zip }}, {{ $subscription->course->location->city }}</li>
    </ul>
    <p>Wir freuen uns darauf, Sie bald bei uns begrüßen zu dürfen! Wenn Sie Fragen haben, stehen wir Ihnen gerne zur Verfügung.</p>
    <p>Mit freundlichen Grüßen,<br>
    Ihr Habaneando-Team</p>
@endsection