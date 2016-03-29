@extends('layouts.app1')

@section('content')

<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Edit Ruang</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($ruang, ['method' => 'PATCH', 'url' => 'ruangData/' . $ruang->id, 'class' => 'form-horizontal']) !!}
						@include ('master/ruang.form', ['SubmitButtonText' => 'Update Ruang'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop