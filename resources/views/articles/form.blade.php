<div class="form-group">
	{!! Form::label('title', 'Title:') !!}
	{!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('body', 'Body:') !!}
	{!! Form::textarea('body', null, ['class' => 'form-control']) !!}			
</div>

<div class="form-group">
	{!! Form::label('published_at', 'Published On:') !!}
	{!! Form::input('date', 'published_at', $article->published_at, ['class' => 'form-control']) !!}			
</div>

<div class="form-group">
	{!! Form::label('tag_list', 'Tags:') !!}
	{!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
</div>

<div class="form-group">
	{!! Form::submit($SubmitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
