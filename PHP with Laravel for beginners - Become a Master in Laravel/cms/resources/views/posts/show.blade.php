@extends('layouts.app')

@section('content')
	
	<h1><a href="{{route('posts.edit', $post->id)}}">{{$post->title}}</a></h1>

@stop

@section('footer')
	<h3>I am footer</h3>
@stop