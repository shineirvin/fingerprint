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

			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">Data Master</span>
				</a>
				<ul>
					<li><a href="{!! url('matakuliahDataView') !!}" class="{!! set_active('matakuliahDataView') !!}"><span class="title">Matakuliah</span></a></li>
					<li><a href="{!! url('ruangDataView') !!}" class="{!! set_active('ruangDataView') !!}"><span class="title">Ruang</span></a></li>
					<li><a href="{!! url('jenisruangDataView') !!}" class="{!! set_active('jenisruangDataView') !!}"><span class="title">Jenis Ruang</span></a></li>
				</ul>
			</li>

			@if (Auth::user()->roles === 'Admin')
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">Users Settings</span>
				</a>
				<ul>
					<li><a href="{!! url('changepassadmin') !!}" class="{!! set_active('changepassadmin') !!}"><span class="title">Admin</span></a></li>
					<li><a href="{!! url('changepassdosen') !!}" class="{!! set_active('changepassdosen') !!}"><span class="title">Dosen</span></a></li>
					<li><a href="{!! url('changepassmahasiswa') !!}" class="{!! set_active('changepassmahasiswa') !!}"><span class="title">Mahasiswa</span></a></li>
				</ul>
			</li>
			<li class="{!! set_active('adminvalidation') !!}">
				<a href="{!! url('adminvalidation') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Attendance Validation</span>
				</a>
			</li>
			<li class="{!! set_active('kelaspenggantiDataView') !!}">
				<a href="{!! url('kelaspenggantiDataView') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Kelas Pengganti</span>
				</a>
			</li>
			<li class="{!! set_active('reportBulanan') !!}">
				<a href="{!! url('reportBulanan') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Bulanan Dosen</span>
				</a>
			</li>
			@endif


		{!! Form::hidden($dosen_id = App\Jadwalkelas::where('dosen_id', Auth::user()->username)->get()) !!}
        @foreach ($dosen_id as $dosen_nim)
            @if (!$dosen_nim)
                {!! Form::hidden($dosen_id = FALSE) !!}
            @else
                {!! Form::hidden($dosen_id = $dosen_nim->dosen_id) !!}
            @endif
        @endforeach

		{!! Form::hidden($mahasiswa_id = App\Asistenkelas::where('nim', Auth::user()->username)->get()) !!}
        @foreach ($mahasiswa_id as $mahasiswa_nim)
            @if (!$mahasiswa_nim) 
                {!! Form::hidden($mahasiswa_id = FALSE) !!}
			@else
                {!! Form::hidden($mahasiswa_id = $mahasiswa_nim->nim) !!}
            @endif
        @endforeach

			@if (Auth::user()->roles === 'Dosen' )
			<li class="{!! set_active('presensi') !!}">
				<a href="{!! url('presensi') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Presensi</span>
				</a>
			</li>
			@endif
			@if (Auth::user()->roles === 'Dosen' && Auth::user()->username == $dosen_id)
			<li class="{!! set_active('presensilab') !!}">
				<a href="{!! url('presensilab') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Presensi Lab</span>
				</a>
			</li>
			@endif	


			@if (Auth::user()->roles === 'Dosen')
			<li class="{!! set_active('reportDosen') !!}">
				<a href="{!! url('reportDosen') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>

			@endif
			@if (Auth::user()->roles === 'Mahasiswa')
			<li class="{!! set_active('reportMahasiswa') !!}">
				<a href="{!! url('reportMahasiswa') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>
			<li class="{!! set_active('reportMahasiswaLab') !!}">
				<a href="{!! url('reportMahasiswaLab') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Lab</span>
				</a>
			</li>											

			@endif
			@if (Auth::user()->roles === 'Admin')
			<li class="{!! set_active('reportAdmin') !!}">
				<a href="{!! url('reportAdmin') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>
			@endif

			@if (Auth::user()->roles === 'Dosen' && Auth::user()->username == $dosen_id)
			<li class="{!! set_active('reportDosenLab') !!}">
				<a href="{!! url('reportDosenLab') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Lab</span>
				</a>
			</li>
			@endif
			@if (Auth::user()->roles === 'Mahasiswa' && Auth::user()->username == $mahasiswa_id)
			<li class="{!! set_active('reportAsdos') !!}">
				<a href="{!! url('reportAsdos') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report Asdos</span>
				</a>
			</li>
			@endif



		</ul>

		<div class="menubar-foot-panel">
			<small class="no-linebreak hidden-folded">
				<span class="opacity-75">Copyright &copy; 2016</span> <strong>Life is Strange</strong>
			</small>
		</div>
	</div>
</div>