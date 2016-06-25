@extends('layout')

@section('content')
	<h1>{{ $card->title }}</h1>

	@foreach ($card->notes as $note)
		<li>{{ $note->body }}</li>
	@endforeach


@stop