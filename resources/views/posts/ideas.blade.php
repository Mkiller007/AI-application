@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go back</a>
  <div class="card">
    <h1>The three most relevant ideas of the post '{!!$post->title!!}':</h1>
    <div style ="white-space: pre-line">{!!$ideas!!}</div>
  </div>
@endsection