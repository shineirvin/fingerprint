@extends ('layouts.app1')

@section ('content')

	<div id="content">
		<section class="style-default-bright">
			<div class="section-header">
				<h2 class="text-primary"> Rekap Kehadiran Mahasiswa Semester {!! $currentsemesterParamsFilter !!}</b> </h2> 
			</div>
			@include('partials.flash')
			<div class="section-body">
				<div class="col-sm-3">
					{!! Form::select('hari_id', $semester, null, ['id' => 'select2', 'class' => 'select2-container form-control input-lg selectpertemuan']) !!}
				</div>
				<div class="row">
					<div class="col-lg-12">
					<a href="{!! url('reportAllMahasiswaLabExcel/'. $currentsemesterParams) !!}" class="btn btn-success"> <i class="fa fa-file-excel-o"> </i> EXCEL </a>
						<div class="table-responsive">
							<table id="datatable1" class="table table-striped table-hover table-bordered">
						        <thead>
						            <tr>
						                <th rowspan="2" style="vertical-align: middle"> NIM </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA MAHASISWA </th>
						                <th rowspan="2" style="vertical-align: middle"> KODE MK </th>
						                <th rowspan="2" style="vertical-align: middle"> NAMA MK </th>
						                <th rowspan="2" style="vertical-align: middle"> SKS </th>
						                <th rowspan="2" style="vertical-align: middle"> KELAS </th>
						                <th colspan="14" style="text-align: center"> PERTEMUAN KE - </th>
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
			"dom": 'Blfrtip',
		    "select": true,
			"iDisplayLength": 100, 
			"order": [[ 0, "asc" ]],
	        ajax: '{!! url('reportMhsLabAdminData/'. $currentsemesterParams) !!}',
	        columns: [
	            { data: 'nim'},
	            { data: 'nama_mahasiswa'},
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
	        ],
	        "buttons": [
	        	{
	                extend: 'pdfHtml5',
	                orientation: 'landscape',
	                message: 'DAFTAR KEHADIRAN DOSEN SEMESTER GANJIL TAHUN AKADEMIK 2016/2017 \n FAKULTAS TEKNOLOGI INFORMASI UNIVERSITAS TARUMANAGARA' ,

	                customize: function ( doc ) {
	                    doc.content.splice( 1, 0, {
	                        margin: [ 0, -40, 0, 12 ],
	                        alignment: 'center',
							height: 100,
							width: 600,
	                        image: 'data:image/png;base64,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'
	                    } );
						
	                },

					title: 'LAPORAN',
	                
	        	}
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