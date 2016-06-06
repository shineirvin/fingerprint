@extends ('layouts.app1')

@section ('content')

	<div id="content">

		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary">Data Master Matakuliah </h2> 
			</div>

			<a href="{!! url('matakuliahData') !!}" class="btn ink-reaction btn-raised btn-primary"><i class="fa fa-plus"></i> &nbsp Tambah Data Matakuliah</a>
			<div class="section-body">

				<!-- BEGIN DATATABLE 1 -->
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover">
						        <thead>
						            <tr>
						                <th>Kode Matakuliah</th>
						                <th>Nama Matakuliah</th>
						                <th>SKS</th>
						                <th>Rec Status</th>
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
		$(document).on('click','#swalalert',function(e) {
			e.preventDefault();
			var data = $(this).attr("href");
			alertFunction(data);
		}); 

		function alertFunction(id)
		{
		    swal({  title: "Are you sure?",
		    		text: "You will not be able to recover this data!",
		    		type: "warning",
		    		showCancelButton: true,
		    		confirmButtonColor: "#DD6B55",   
		    		confirmButtonText: "Yes, delete it!",   
		    		closeOnConfirm: false,
		    		closeOnCancel: true },
		    		function(isConfirm)	{
						if (isConfirm) {
							$.ajax({
								headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
								url: 'matakuliahDataDelete/'+ id,
								method: 'get',
								success: function() {
									swal({ title: "Deleted!",
										   text: "Your data has been deleted.", 
										   timer: 2000,
										   type: "success",
										   showConfirmButton: false });
									setTimeout("location.href = 'matakuliahDataView'",2000);
								}
							})
						}
					}
			);
		}
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"order": [[ 1, "asc" ]],
	        ajax: '{!! url('getDatamatakuliah') !!}',
	        columns: [
	            { data: 'kode_matakuliah'},
	            { data: 'nama_matakuliah'},
	            { data: 'sks'},
	            { data: 'recstatus'},
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