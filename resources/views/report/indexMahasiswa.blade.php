@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Rekap Kehadiran <b> {{ Auth::user()->name }} ( {{ Auth::user()->username }} ) </b> </h2> 
			</div>
			@include('partials.flash')
			<div class="section-body">

				<!-- BEGIN DATATABLE 1 -->
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover table-bordered">
						        <thead>
						            <tr>
						                <th rowspan="2" style="vertical-align: middle"> KODE MK </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA MATAKULIAH </th>
						                <th rowspan="2" style="vertical-align: middle"> SKS </th>
						                <th rowspan="2" style="vertical-align: middle"> KELAS </th>
						                <th colspan="13" style="text-align: center"> MINGGU KE - </th>
						                <th rowspan="2" style="vertical-align: middle"> JML HADIR </th>


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
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"iDisplayLength": 100, 
			"order": [[ 0, "asc" ]],
	        ajax: '{!! url('reportMahasiswaData') !!}',
	        columns: [
	            { data: 'matakuliah_id'},
	            { data: 'nama_matakuliah'},
	            { data: 'sks'},
	            { data: 'kelas'},
	            { data: '1'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
	            { data: '2'},
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