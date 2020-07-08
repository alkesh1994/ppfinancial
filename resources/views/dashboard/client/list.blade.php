@extends('layouts.app')

@section('content')
test
@if($clients->count())
@foreach($clients as $client)
<li>{{$client->client_first_name}}</li>
@endforeach
@else
no client exist
@endif


@endsection
