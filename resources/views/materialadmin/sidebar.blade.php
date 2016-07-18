{!! Form::hidden($datetime = Carbon\Carbon::now()) !!}
{!! Form::hidden($currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2') )!!}
<div id="menubar" class="menubar-inverse ">
	<div class="menubar-fixed-panel">
		<div>
			<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
				<i class="fa fa-bars"></i>
			</a>
		</div>
		<div class="expanded">
			<a href="materialadmin/html/dashboards/dashboard.html">
				<span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
			</a>
		</div>
	</div>
	<div class="menubar-scroll-panel">

		<!-- BEGIN MAIN MENU -->
		<ul id="main-menu" class="gui-controls">

			<!-- BEGIN DASHBOARD -->
			<li class="{!! set_active('index') !!}">
				<a href="{!! url('index') !!}">
					<div class="gui-icon"><i class="md md-home"></i></div>
					<span class="title">Dashboard</span>
				</a>
			</li><!--end /menu-li -->
			<!-- END DASHBOARD -->


			
			@if (Auth::user()->roles === 'Admin')
{{-- 			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">Data Master</span>
				</a>
				<ul>
					<li><a href="{!! url('matakuliahDataView') !!}" class="{!! set_active('matakuliahDataView') !!}"><span class="title">Matakuliah</span></a></li>
					<li><a href="{!! url('ruangDataView') !!}" class="{!! set_active('ruangDataView') !!}"><span class="title">Ruang</span></a></li>
					<li><a href="{!! url('jenisruangDataView') !!}" class="{!! set_active('jenisruangDataView') !!}"><span class="title">Jenis Ruang</span></a></li>
				</ul>
			</li> --}}

			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">Kelola Users</span>
				</a>
				<ul>
					<li><a href="{!! url('changepassadmin') !!}" class="{!! set_active('changepassadmin') !!}"><span class="title">Admin</span></a></li>
					<li><a href="{!! url('changepassdosen') !!}" class="{!! set_active('changepassdosen') !!}"><span class="title">Dosen</span></a></li>
					<li><a href="{!! url('changepassmahasiswa') !!}" class="{!! set_active('changepassmahasiswa') !!}"><span class="title">Mahasiswa</span></a></li>
				</ul>
			</li>
			{{-- <li class="{!! set_active('adminvalidation/'. $currentsemesterDirty) !!}">
				<a href="{!! url('adminvalidation/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Validasi Absensi</span>
				</a>
			</li> --}}
			<li class="{!! set_active('adminvalidationLab') !!}">
				<a href="{!! url('adminvalidationLab/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Validasi Absensi Lab</span>
				</a>
			</li>
			{{-- <li class="{!! set_active('kelaspenggantiDataView') !!}">
				<a href="{!! url('kelaspenggantiDataView') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Kelas Pengganti</span>
				</a>
			</li> --}}
			<li class="{!! set_active('kelaspenggantiLabDataView') !!}">
				<a href="{!! url('kelaspenggantiLabDataView') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Kelas Pengganti Lab</span>
				</a>
			</li>
			{{-- <li class="{!! set_active('reportBulanan') !!}">
				<a href="{!! url('reportBulanan') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Bulanan Dosen</span>
				</a>
			</li> --}}
			@endif


		{!! Form::hidden($dosen_id = App\Jadwalkelas::where('user_id', Auth::user()->id)->where('status', '1')->get()) !!}
        @foreach ($dosen_id as $dosen_nim)
            @if (!$dosen_nim)
                {!! Form::hidden($dosen_ids = FALSE) !!}
            @else
                {!! Form::hidden($dosen_ids = $dosen_nim->user_id) !!}
            @endif
        @endforeach

		{!! Form::hidden($mahasiswa_id = App\Asistenkelas::where('user_id', Auth::user()->id)->where('status', '1')->get()) !!}
	        @foreach ($mahasiswa_id as $mahasiswa_nim)
	            @if (!$mahasiswa_nim) 
	                {!! Form::hidden($mahasiswa_ids = FALSE) !!}
				@else
	                {!! Form::hidden($mahasiswa_ids = $mahasiswa_nim->user_id) !!}
	            @endif
	        @endforeach

			@if (Auth::user()->roles === 'Dosen' )
			{{-- <li class="{!! set_active('listJadwalDosen/'. $currentsemesterDirty) !!}">
				<a href="{!! url('listJadwalDosen/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title"> Jadwal Perkuliahan </span>
				</a>
			</li> --}}
			{{-- <li class="{!! set_active('presensi/'. $currentsemesterDirty) !!}">
				<a href="{!! url('presensi/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title"> Validasi Absensi</span>
				</a>
			</li> --}}
			@endif
			@if(isset($dosen_ids))
				@if (Auth::user()->roles === 'Dosen' && Auth::user()->id == $dosen_ids)
				<li class="{!! set_active('presensilab/'. $currentsemesterDirty) !!}">
					<a href="{!! url('presensilab/'. $currentsemesterDirty) !!}">
						<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
						<span class="title"> Validasi Absensi Lab</span>
					</a>
				</li>
				@endif
			@endif	


			@if (Auth::user()->roles === 'Dosen')
			{{-- <li class="{!! set_active('reportDosen/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportDosen/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li> --}}
			@endif 
			@if(isset($dosen_ids))
				@if (Auth::user()->roles === 'Dosen' && Auth::user()->id == $dosen_ids)
				<li class="{!! set_active('reportDosenLab/'. $currentsemesterDirty) !!}">
					<a href="{!! url('reportDosenLab/'. $currentsemesterDirty) !!}">
						<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
						<span class="title">Report Lab </span>
					</a>
				</li>
				@endif
			@endif
			@if (Auth::user()->roles === 'Dosen')
			{{-- <li class="{!! set_active('reportDosenDetail/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportDosenDetail/'. $currentsemesterDirty. '/0/0') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Mahasiswa</span>
				</a>
			</li> --}}
			<li class="{!! set_active('reportDosenDetailLab/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportDosenDetailLab/'. $currentsemesterDirty. '/0/0') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Mahasiswa Lab</span>
				</a>
			</li>

			@endif
			@if (Auth::user()->roles === 'Mahasiswa')
			{{-- <li class="{!! set_active('reportMahasiswa/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportMahasiswa/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li> --}}
			<li class="{!! set_active('reportMahasiswaLab/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportMahasiswaLab/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Lab</span>
				</a>
			</li>											
			@endif



			@if (Auth::user()->roles === 'Admin')
			{{-- <li class="{!! set_active('reportAdmin/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportAdmin/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Dosen</span>
				</a>
			</li> --}}
			<li class="{!! set_active('reportAdminLab/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportAdminLab/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Dosen Lab</span>
				</a>
			</li>
			{{-- <li class="{!! set_active('reportMhsAdmin/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportMhsAdmin/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Mahasiswa</span>
				</a>
			</li> --}}
			<li class="{!! set_active('reportMhsLabAdmin/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportMhsLabAdmin/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Mahasiswa Lab</span>
				</a>
			</li>
			<li class="{!! set_active('reportAllAsdos/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportAllAsdos/'. $currentsemesterDirty) !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Asdos Lab</span>
				</a>
			</li>
			{{-- <li class="{!! set_active('reportAdminDosenDetail/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportAdminDosenDetail/'. $currentsemesterDirty. '/0/0/0') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Dosen Detail</span>
				</a>
			</li> --}}
			<li class="{!! set_active('reportAdminDosenDetailLab/'. $currentsemesterDirty) !!}">
				<a href="{!! url('reportAdminDosenDetailLab/'. $currentsemesterDirty. '/0/0/0') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Dosen Lab Detail</span>
				</a>
			</li>
			@endif

			@if(isset($mahasiswa_ids))
				@if (Auth::user()->roles === 'Mahasiswa' && Auth::user()->id == $mahasiswa_ids)
				<li class="{!! set_active('reportAsdos/'. $currentsemesterDirty) !!}">
					<a href="{!! url('reportAsdos/'. $currentsemesterDirty) !!}">
						<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
						<span class="title">Report Asdos</span>
					</a>
				</li>
				@endif
			@endif



		</ul>

		<div class="menubar-foot-panel">
			<small class="no-linebreak hidden-folded">
				<span class="opacity-75">Copyright &copy; 2016</span> <strong>Life is Strange</strong>
			</small>
		</div>
	</div>
</div>