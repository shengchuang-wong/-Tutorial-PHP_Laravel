@extends('layouts.app')

@section('content')

	<h1>Edit Post</h1>
	
	<form method="post" action="../{{$post->id}}">

		<input type="hidden" name="_method" value="PUT">

		<input type="text" name="title" placeholder="Enter title" value="{{$post->title}}">

		<input type="submit" name="submit" value="UPDATE">

		<!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->

		{{ csrf_field() }}

	</form>

	<form method="post" action="../{{$post->id}}">
		<input type="hidden" name="_method" value="DELETE">

		<input type="submit" value="DELETE">

		{{ csrf_field() }}
		
	</form>

@stop

@section('footer')
	<h3>I am footer</h3>
@stop