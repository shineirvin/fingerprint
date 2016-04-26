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
						{!! Form::open(['url' => 'studentvalidate', 'method' => 'POST']) !!}
						<input name="idpage" type="hidden" value="{!! $id !!}">
							<table id="datatable1" class="table table-striped table-hover">
						        <thead>
						            <tr>
						                <th>NIM</th>
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
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"iDisplayLength": 100,
			"order": [[ 1, "asc" ]],
	        ajax: '{!! url('getDataPresensiMahasiswa/'.$id) !!}',

	        columns: [
	            { data: 'NIM'},
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