@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Jadwal Kelas Lab </h2> 
			</div>
			@include('partials.flash')
			<div class="section-body">
				<!-- BEGIN DATATABLE 1 -->
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover">
						        <thead>
						            <tr>
						                <th>Semester</th>
						                <th>NIM</th>
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
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"iDisplayLength": 100, 
			"order": [[ 0, "asc" ]],
	        ajax: '{!! url('getDataListJadwalkelas') !!}',
	        columns: [
	            { data: 'semester'},
	            { data: 'nim'},
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

/*		$('#datatable1 tbody').on('click', 'tr', function() {
			$(this).toggleClass('selected');
		});*/

		$('div.alert-success').not('alert-important').delay(6000).slideUp(300);

	});

</script>

@stop