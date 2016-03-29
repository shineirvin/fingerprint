@extends('layouts.app1')

@section('content')


<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Tambah Matakuliah</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($matakuliah = new App\Matakuliah, ['url' => 'matakuliahData', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
						@include ('master/matakuliah.form', ['SubmitButtonText' => 'Tambah Matakuliah'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop