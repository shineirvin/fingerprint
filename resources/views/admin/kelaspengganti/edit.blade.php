@extends('layouts.app1')

@section('content')

<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Edit Kelas Pengganti</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($kelaspengganti, ['method' => 'PATCH', 'url' => 'kelaspenggantiData/' . $kelaspengganti->id, 'class' => 'form-horizontal']) !!}
						@include ('admin/kelaspengganti.form', ['SubmitButtonText' => 'Update Kelas Pengganti'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop