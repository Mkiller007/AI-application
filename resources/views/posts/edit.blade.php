@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    {!!Form::open(['url'=>'posts/'.$post->id, 'method'=>'POST', 'enctype'=>'multipart/form-data'])!!}
      <div class="form-group">
          {!!Form::label('title','Title')!!}
          {!!Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Title'])!!}
      </div>
      <div class="form-group">
        {!!Form::label('body','Body')!!}
        {!!Form::textarea('body',$post->body,['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Body Text'])!!}
      </div>
      <div class="form-group">
        <p>Upload a cover image (Optional). You can let this field empty and let our AI create a cover image for you. It may take some time, be patient.</p>
        <input type="file" class="form-control" name="cover_image" />
      </div>
      <br>
      <div class="form-group">
        {!!Form::submit('Submit',['class'=>'btn btn-primary'])!!}
      </div>
      {!!Form::hidden('_method','PUT')!!}
    {!!Form::close()!!}
@endsection