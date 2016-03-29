@extends('layouts.app')

@section('content')
	<h1>Edit: "{!! $article->title !!}"</h1>
	<h3> Edit and save this article below, or <a href="/articles"> go back to all articles </a> </h3>
	<hr> 

	{!! Form::model($article, ['method' => 'PATCH', 'url' => 'articles/' . $article->id]) !!}
		@include ('articles.form', ['SubmitButtonText' => 'Update Article'])
	{!! Form::close() !!}

	@include ('errors.list')

@stop