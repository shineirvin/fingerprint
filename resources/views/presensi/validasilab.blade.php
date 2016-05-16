@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Validasi Presensi Mahasiswa 
				@if($encounter == 0)
				( Silahkan Pilih Pertemuan )</h2>
				@else 
				Pertemuan ke - {{ $encounter }} </h2>
				@endif
			</div>
			@include('partials.flash')
			<div class="section-body">
			<div class="col-lg-3">
				{!! Form::select('pertemuan', 
					   ['' => 'PILIH PERTEMUAN', 
					   '1' => 'PERTEMUAN - 1', 
					   '2' => 'PERTEMUAN - 2', 
					   '3' => 'PERTEMUAN - 3',
					   '4' => 'PERTEMUAN - 4',
					   '5' => 'PERTEMUAN - 5',
					   '6' => 'PERTEMUAN - 6',
					   '7' => 'PERTEMUAN - 7',
					   '8' => 'PERTEMUAN - 8',
					   '9' => 'PERTEMUAN - 9',
					   '10' => 'PERTEMUAN - 10',
					   '11' => 'PERTEMUAN - 11',
					   '12' => 'PERTEMUAN - 12',
					   '13' => 'PERTEMUAN - 13',
					   '14' => 'PERTEMUAN - 14',], null,  array('class'=>'form-control input-lg', 'id' => 'selectpertemuan')) !!}
				</div>
				<!-- BEGIN DATATABLE 1 -->
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
						{!! Form::open(['url' => 'studentvalidate', 'method' => 'POST']) !!}
						<input name="idpage" type="hidden" value="{!! $id !!}">
							<table id="datatable1" class="table table-striped table-hover">
						        <thead>
						            <tr>
						                <th>NIM</th>
						                <th>Nama</th>
						                <th>Waktu</th>
						                <th>
						                	<span style="padding-right: 15%;">
						                		Hadir
						                	</span>
						                	<span style="padding-right: 15%;">
						                		Sakit
						                	</span>
						                	<span style="padding-right: 15%;">
						                		Izin
						                	</span>
						                	 Tidak Masuk</th>
						            </tr>
						        </thead>
							    <tfoot>
										<tr>
									    <th></th>
									    <th></th>
									    <th style="text-align: center;"><button type="submit" class="btn btn-primary">Submit</button></th>
									</tr>
								</tfoot>
							</table>
						{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<script>
	$(document).ready(function() {
		$( "#selectpertemuan" ).change(function() {
			var selected = $('#selectpertemuan').val();
			window.location = selected;
		});
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"iDisplayLength": 100,
			"order": [[ 1, "asc" ]],
	        ajax: '{!! url('getDataPresensiMahasiswaLab/'.$id.'/'.$encounter) !!}',

	        columns: [
	            { data: 'nim'},
	            { data: 'name'},
	            { data: 'waktu'},
	            { data: 'keterangan', name: 'keterangan', orderable: false, searchable: false},
	        ],
			"language": {
				"lengthMenu": '_MENU_ entries per page',
				"search": '<i class="fa fa-search"></i>',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}
		});

	});

</script>

@stop