@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Jadwal Perkuliahan Semester {!! $currentsemesterParamsFilter !!} </h2> 
			</div>
			<div class="section-body">
				<div class="col-sm-3">
					{!! Form::select('hari_id', $semester, null, ['id' => 'select2', 'class' => 'select2-container form-control input-lg selectpertemuan']) !!}
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover">
						        <thead>
						            <tr>
						                <th>Hari id</th>
						                <th>NIK</th>
						                <th>Nama</th>
						                <th>Matakuliah</th>
						                <th>Kelas</th>
						                <th>Hari</th>
						                <th>Ruang</th>
						                <th>Waktu</th>
						                <th>Action</th>
						            </tr>
						        </thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<script>
	$(document).ready(function()
	{
	$( "#select2" ).change(function() {
			var selected = $('#select2 option:selected').text();
			var tahun = selected.slice(0,4);
			var filteredSelect = selected.slice(5,11);
			if (filteredSelect == 'GANJIL') {
				TrueSelected = tahun+'1';
			}
			else {
				TrueSelected = tahun+'2';
			}
			window.location = TrueSelected;
	});
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"iDisplayLength": 100, 
			"order": [[ 0, "asc" ]],
	        ajax: '{!! url('getDataJadwalDosenLabAll/'. $currentsemesterParams) !!}',
	        columns: [
	            { data: 'hari_id', visible: false },
	            { data: 'dosen_id'},
	            { data: 'name'},
	            { data: 'matakuliah_id'},
	            { data: 'kelas'},
	            { data: 'hari_name'},
	            { data: 'ruang_id'},
	            { data: 'waktu'},
	            { data: 'action', name: 'action', orderable: false, searchable: false}
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