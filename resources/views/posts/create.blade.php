@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        {!!Form::label('title','Title')!!}
        {!!Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])!!}
      </div>
      <div class="form-group">
        {!!Form::label('body','Body')!!}
        {!!Form::textarea('body','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Body Text'])!!}
      </div>
      <div class="form-group">
        <p>Upload a cover image (Optional). You can let this field empty and let our AI create a cover image for you. It may take some time, be patient.</p>
        <input type="file" class="form-control" name="cover_image" />
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection