@extends('layouts.app')

@section('content')
      <h1>{{$title}}</h1>
      
      <p>Welcome to MyAiApp, a revolutionary platform! <br> Here you can write and read posts while being assisted by a powerful AI.</p>

      Here is a set of features offered for the moment:
      <br><br>
      <strong>Because  your time is precious:</strong> 
      <ul>
            <li>We summarize posts for you.</li>
            <li>We offer to extract the relevant ideas from the posts.</li>
      </ul>
      <strong>Because it's elegant:</strong>
      <ul>
            <li>{{ config('app.name', 'MyAiApp')}} helps you through the post creation by generating a unique cover image for your posts.</li>
            <li>AI can also generate an image from any post on the platform.</li>
      </ul>


@endsection