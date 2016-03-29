@extends('layouts.app1')

@section('content')

<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Tambah Jenis Ruang</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($jenisruang = new App\Jenisruang, ['url' => 'jenisruangData', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
						@include ('master/jenisruang.form', ['SubmitButtonText' => 'Tambah Jenis Ruang'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->

@stop