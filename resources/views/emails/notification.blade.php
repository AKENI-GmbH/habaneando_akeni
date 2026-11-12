@extends('emails.email')

@section('content')
<p>{!! nl2br(e($body)) !!}</p>
@endsection
