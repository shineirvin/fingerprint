@extends('layouts.app1')

@section('content')


<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Tambah Kelas Pengganti</h2>
		</div>
		<div class="section-body"> <br>
			<div class="card">
				<div class="card-body">
					@include ('errors.list')
					{!! Form::model($kelaspengganti = new App\Kelaspengganti, ['url' => 'kelaspenggantiData', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
						@include ('admin/kelaspengganti.form', ['SubmitButtonText' => 'Tambah Kelas Pengganti'])
					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->
	@section('clockpicker')
		<script>        	
        	$('.clockpicker').clockpicker();
        </script>
    @endsection
@stop