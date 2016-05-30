@extends ('layouts.app1')

@section ('content')
			<!-- BEGIN CONTENT-->
			<div id="content">
				<section class="style-default-bright">
					<div class="section-header">
						<h2 class="text-primary">DataTables</h2>
					</div>
					<div class="section-body">
						<a href="registeradmin" class="btn btn-success"> <i class="fa fa-plus"> </i>  Register Admin Baru </a>
						<!-- BEGIN DATATABLE 1 -->
						<div class="row">
							<div class="col-lg-12">
								<div class="table-responsive">
									<table id="datatable" class="table table-striped table-hover">
								        <thead>
								            <tr>
								                <th>NIP</th>
								                <th>Name</th>
								                <th>Email</th>
								                <th>Created At</th>
								                <th>Updated At</th>
								                <th>Action</th>
								            </tr>
								        </thead>
									</table>
								</div><!--end .table-responsive -->
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END DATATABLE 1 -->
						@include('modal.adminModal')
						<hr class="ruler-xxl"/>

					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

<script>
	$(document).ready(function()
	{
		$('#datatable').DataTable({
			"dom": 'lCfrtip',
			"order": [],
	        ajax: '{!! url('changepassadminData') !!}',
	        columns: [
	            { data: 'username' },
	            { data: 'name' },
	            { data: 'email' },
	            { data: 'created_at' },
	            { data: 'updated_at' },
	            { data: 'action' }
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


        $("#datatable").on("click",".open-modal", function() {
        	$.get('getAdminData' + '/' + $(this).val(), function(data) {
        		$('#id').val(data.id);
        		document.getElementById("id").readOnly=true;
        		$('#username').val(data.username);
        		document.getElementById("username").readOnly=true;
        		$('#name').val(data.name);
        		document.getElementById("name").readOnly=true;
        		$('#email').val(data.email);
        		document.getElementById("email").readOnly=true;
        	});
	        $("#myModal").modal('show');
	    });



	});
</script>

@endsection