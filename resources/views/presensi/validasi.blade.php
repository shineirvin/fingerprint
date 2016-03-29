@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Validasi Presensi Mahasiswa </h2> 
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
						                <th>NIM</th>
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
	$(document).ready(function() {
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"order": [[ 1, "asc" ]],
	        ajax: '{!! url('getDataPresensiMahasiswa/'.$idjadwal) !!}',
	        columns: [
	            { data: 'id'},
	            { data: 'datetime'},
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