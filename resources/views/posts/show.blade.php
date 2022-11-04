@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go back</a>
    <h1>{{$post->title}}</h1>
    <div class="row">
      <div class="col-md-4 col-sm4">

          <img src="{{$post->cover_image}}" style="width:100%">
      </div>
      <div class="col-md-8 col-sm8"></div>
  </div>
    <br>
    <br>
    <div>
      {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
      @if (Auth::user()->id == $post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
        {!!Form::open(['url' => ['posts', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}          
      @endif
    @endif
@endsection