@extends('layouts.app1')

@section('content')

<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Edit Matakuliah</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($jenisruang, ['method' => 'PATCH', 'url' => 'jenisruangData/' . $jenisruang->id, 'class' => 'form-horizontal']) !!}
						@include ('master/jenisruang.form', ['SubmitButtonText' => 'Update Matakuliah'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop