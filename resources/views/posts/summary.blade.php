@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go back</a>
  <div class="card">
    <h1>The summary of the post '{!!$post->title!!}':</h1>
    {!!$summary!!}
  </div>
@endsection