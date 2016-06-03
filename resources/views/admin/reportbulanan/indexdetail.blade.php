@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Rekap Bulanan Kehadiran Dosen ( {!! $start !!}   -   {!! $end !!} )</b> </h2> 
			</div>
			@include('partials.flash')
			<div class="section-body">

				<a href="{!! url('monthlyreportexcel/'. $datestart . '/'. $dateend) !!}" class="btn btn-success"> <i class="fa fa-file-excel-o"> </i> EXCEL </a>
				<!-- BEGIN DATATABLE 1 -->
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover table-bordered">
						        <thead>
						            <tr>
						                <th rowspan="2" style="vertical-align: middle"> NIK </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA DOSEN </th>
						                <th rowspan="2" style="vertical-align: middle"> KODE MK </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA MK </th>
						                <th rowspan="2" style="vertical-align: middle"> SKS </th>
						                <th rowspan="2" style="vertical-align: middle"> KELAS </th>
						                <th colspan="4" style="text-align: center"> PERTEMUAN KE - </th>
						                <th rowspan="2" style="vertical-align: middle"> JML HADIR </th>
						                <th rowspan="2" style="vertical-align: middle"> PRESENTASE </th>


						            </tr>
						            <tr>
						                <th> 1 </th>
						                <th> 2 </th>
						                <th> 3 </th>
						                <th> 4 </th>

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
			"dom": 'lfrtip',
		    "select": true,
			"iDisplayLength": 100, 
			"order": [[ 0, "asc" ]],
	        ajax: '{!! url('getDataReportBulanan/'. $datestart . '/'. $dateend) !!}',
	        columns: [
	            { data: 'dosen_id'},
	            { data: 'nama_dosen'},
	            { data: 'matakuliah_id'},
	            { data: 'nama_matakuliah'},
	            { data: 'sks'},
	            { data: 'kelas'},
	            { data: '1'},
	            { data: '2'},
	            { data: '3'},
	            { data: '4'},
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