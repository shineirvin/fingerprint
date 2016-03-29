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
					{!! Form::model($matakuliah, ['method' => 'PATCH', 'url' => 'matakuliahData/' . $matakuliah->kode_matakuliah, 'class' => 'form-horizontal']) !!}
						@include ('master/matakuliah.form', ['SubmitButtonText' => 'Update Matakuliah'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop