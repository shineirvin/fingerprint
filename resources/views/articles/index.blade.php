@extends('layouts.app')

@section('content')

@include('partials.flash')
	
	<h1 style="font-weight: bold"> Articles </h1>
	<h3> Here's a list all your article. <a href="/articles/create/"> Add a new one ? </a> </h3>

	<hr>

	@foreach ($articles as $article)
		<article>
			<h2 style="font-weight: bold"> 
				<a href="/articles/{!! $article->id !!}"> {!! $article->title !!} </a> 
			</h2>

			<div class="body">{!! $article->body !!}</div>
		</article>

		
		{!! Form::open(['method' => 'DELETE', 'url' => 'articles/' . $article->id]) !!}
			<a href="/articles/{!! $article->id !!}/edit/" class="btn btn-warning"> <i class="fa fa-pencil"></i></a>
			<button type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
		{!! Form::close() !!}

	<br>
	@endforeach



@stop