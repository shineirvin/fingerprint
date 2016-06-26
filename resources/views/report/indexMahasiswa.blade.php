@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Rekap Kehadiran <b> {{ Auth::user()->name }} ( {{ Auth::user()->username }} ) Semester {!! $currentsemesterParamsFilter !!} </b> </h2> 
			</div>
			@include('partials.flash')
			<div class="section-body">
				<div class="col-sm-3">
					{!! Form::select('hari_id', $semester, null, ['id' => 'select2', 'class' => 'select2-container form-control input-lg selectpertemuan']) !!}
				</div>
				<div class="row">
					<div class="col-lg-12">
					<a href="{!! url('reportMahasiswaExcel/'. $currentsemesterParams) !!}" class="btn btn-success"> <i class="fa fa-file-excel-o"> </i> EXCEL </a>
					<small> NB : 1 = Hadir   &nbsp&nbsp&nbsp   2 = Sakit  &nbsp&nbsp&nbsp    3 = Izin  &nbsp&nbsp&nbsp&nbsp    4 = Tidak Hadir </small>
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover table-bordered">
						        <thead>
						            <tr>
						                <th rowspan="2" style="vertical-align: middle"> KODE MK </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA MATAKULIAH </th>
						                <th rowspan="2" style="vertical-align: middle"> SKS </th>
						                <th rowspan="2" style="vertical-align: middle"> KELAS </th>
						                <th colspan="14" style="text-align: center"> PERTEMUAN KE - </th>
						                <th rowspan="2" style="vertical-align: middle"> JML HADIR </th>
						                <th rowspan="2" style="vertical-align: middle"> PERSENTASE </th>


						            </tr>
						            <tr>
						                <th> 1 </th>
						                <th> 2 </th>
						                <th> 3 </th>
						                <th> 4 </th>
						                <th> 5 </th>
						                <th> 6 </th>
						                <th> 7 </th>
						                <th> 8 </th>
						                <th> 9 </th>
						                <th> 10 </th>
						                <th> 11 </th>
						                <th> 12 </th>
						                <th> 13 </th>
						                <th> 14 </th>

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
	        ajax: '{!! url('reportMahasiswaData/'. $currentsemesterParams) !!}',
	        columns: [
	            { data: 'matakuliah_id'},
	            { data: 'nama_matakuliah'},
	            { data: 'sks'},
	            { data: 'kelas'},
	            { data: '1'},
	            { data: '2'},
	            { data: '3'},
	            { data: '4'},
	            { data: '5'},
	            { data: '6'},
	            { data: '7'},
	            { data: '8'},
	            { data: '9'},
	            { data: '10'},
	            { data: '11'},
	            { data: '12'},
	            { data: '13'},
	            { data: '14'},
	            { data: 'jml_hadir'},
	            { data: 'presentase'},
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

/*		$('#datatable1 tbody').on('click', 'tr', function() {
			$(this).toggleClass('selected');
		});*/

		$('div.alert-success').not('alert-important').delay(6000).slideUp(300);

	});

</script>

@stop