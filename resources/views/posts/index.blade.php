@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts)>0)
        @foreach ($posts as $post)
             <div class="card">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small>Created on {{$post->created_at}} by {{$post->user->name}}</small>
                <div class="row">
                    <div class="col-md-4 col-sm4">
                        <img src="{{$post->cover_image}}" style="width:100%">
                    </div>
                    <div class="col-md-8 col-sm8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">AI is here to help</h5>
                                <p class='card-text'>Show a brief summary of the post:</p>
                                <a href="/posts/{{$post->id}}/summary" class="btn btn-primary">Summarize</a>
                                <br><br>
                                <p class='card-text'>Extract the 3 most relevent ideas of the post:</p>
                                <a href="/posts/{{$post->id}}/ideas" class="btn btn-primary">Extract</a>
                                <br><br>
                                <p class='card-text'>Let our AI create a cover image from the post. It may take some time, be patient.</p>
                                <a href="/posts/{{$post->id}}/generateimage" class="btn btn-primary">Generate image</a>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        @endforeach
        {{$posts->links('pagination::bootstrap-4')}}
    @else
        <p>No posts found</p>
    @endif
@endsection