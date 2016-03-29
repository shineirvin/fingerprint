@extends('layouts.app')

@section('content')

	<h1> Write a New Article </h1>

	<hr>

	{!! Form::model($article = new App\Article, ['url' => 'articles']) !!}
		@include ('articles.form', ['SubmitButtonText' => 'Add Article'])
	{!! Form::close() !!}

	@include ('errors.list')

@stop