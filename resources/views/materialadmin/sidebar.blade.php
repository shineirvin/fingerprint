<!-- BEGIN MENUBAR-->
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


			<!-- BEGIN UI -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">Data Master</span>
				</a>
				<!--start submenu -->
				<ul>
					<li><a href="{!! url('matakuliahDataView') !!}" class="{!! set_active('matakuliahDataView') !!}"><span class="title">Matakuliah</span></a></li>
					<li><a href="{!! url('ruangDataView') !!}" class="{!! set_active('ruangDataView') !!}"><span class="title">Ruang</span></a></li>
					<li><a href="{!! url('jenisruangDataView') !!}" class="{!! set_active('jenisruangDataView') !!}"><span class="title">Jenis Ruang</span></a></li>
				</ul><!--end /submenu -->
			</li><!--end /menu-li -->
			<!-- END UI -->


			<!-- BEGIN EMAIL -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="md md-email"></i></div>
					<span class="title">Email</span>
				</a>
				<!--start submenu -->
				<ul>
					<li><a href="materialadmin/html/mail/inbox.html" ><span class="title">Inbox</span></a></li>
					<li><a href="materialadmin/html/mail/compose.html" ><span class="title">Compose</span></a></li>
					<li><a href="materialadmin/html/mail/reply.html" ><span class="title">Reply</span></a></li>
					<li><a href="materialadmin/html/mail/message.html" ><span class="title">View message</span></a></li>
				</ul><!--end /submenu -->
			</li><!--end /menu-li -->
			<!-- END EMAIL -->

			<!-- BEGIN DASHBOARD -->
			<li class="{!! set_active('practice') !!}">
				<a href="{!! Url('practice/') !!}">
					<div class="gui-icon"><i class="md md-web"></i></div>
					<span class="title">Layouts</span>
				</a>
			</li><!--end /menu-li -->
			<!-- END DASHBOARD -->

			<!-- BEGIN UI -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
					<span class="title">UI elements</span>
				</a>
				<!--start submenu -->
				<ul>
					<li><a href="materialadmin/html/ui/colors.html" ><span class="title">Colors</span></a></li>
					<li><a href="materialadmin/html/ui/typography.html" ><span class="title">Typography</span></a></li>
					<li><a href="materialadmin/html/ui/cards.html" ><span class="title">Cards</span></a></li>
					<li><a href="materialadmin/html/ui/buttons.html" ><span class="title">Buttons</span></a></li>
					<li><a href="materialadmin/html/ui/lists.html" ><span class="title">Lists</span></a></li>
					<li><a href="materialadmin/html/ui/tabs.html" ><span class="title">Tabs</span></a></li>
					<li><a href="materialadmin/html/ui/accordions.html" ><span class="title">Accordions</span></a></li>
					<li><a href="materialadmin/html/ui/messages.html" ><span class="title">Messages</span></a></li>
					<li><a href="materialadmin/html/ui/offcanvas.html" ><span class="title">Off-canvas</span></a></li>
					<li><a href="materialadmin/html/ui/grid.html" ><span class="title">Grid</span></a></li>
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Icons</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="materialadmin/html/ui/icons/materialicons.html" ><span class="title">Material Design Icons</span></a></li>
							<li><a href="materialadmin/html/ui/icons/fontawesome.html" ><span class="title">Font Awesome</span></a></li>
							<li><a href="materialadmin/html/ui/icons/glyphicons.html" ><span class="title">Glyphicons</span></a></li>
							<li><a href="materialadmin/html/ui/icons/skycons.html" ><span class="title">Skycons</span></a></li>
						</ul><!--end /submenu -->
					</li><!--end /menu-li -->
				</ul><!--end /submenu -->
			</li><!--end /menu-li -->
			<!-- END UI -->

			<!-- BEGIN TABLES -->
			<li class="{!! set_active('datatables') !!}">
				<a href="{!! url('datatables') !!}">
					<div class="gui-icon"><i class="fa fa-table"></i></div>
					<span class="title">Tables</span>
				</a>
			</li><!--end /menu-li -->
			<!-- END TABLES -->

			<li class="{!! set_active('presensi') !!}">
				<a href="{!! url('presensi') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Presensi</span>
				</a>
			</li>

			@if ( Auth::user()->roles === 'Dosen' )
			<li class="{!! set_active('reportDosen') !!}">
				<a href="{!! url('reportDosen') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>
			@elseif ( Auth::user()->roles === 'Mahasiswa' )
			<li class="{!! set_active('reportMahasiswa') !!}">
				<a href="{!! url('reportMahasiswa') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>
			@elseif ( Auth::user()->roles === 'Admin' )
			<li class="{!! set_active('reportAdmin') !!}">
				<a href="{!! url('reportAdmin') !!}">
					<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
					<span class="title">Report</span>
				</a>
			</li>
			@endif


			<!-- BEGIN FORMS -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><span class="glyphicon glyphicon-list-alt"></span></div>
					<span class="title">Forms</span>
				</a>
				<!--start submenu -->
				<ul>
					<li><a href="materialadmin/html/forms/basic.html" ><span class="title">Form basic</span></a></li>
					<li><a href="materialadmin/html/forms/advanced.html" ><span class="title">Form advanced</span></a></li>
					<li><a href="materialadmin/html/forms/layouts.html" ><span class="title">Form layouts</span></a></li>
					<li><a href="materialadmin/html/forms/editors.html" ><span class="title">Editors</span></a></li>
					<li><a href="materialadmin/html/forms/validation.html" ><span class="title">Form validation</span></a></li>
					<li><a href="materialadmin/html/forms/wizard.html" ><span class="title">Form wizard</span></a></li>
				</ul><!--end /submenu -->
			</li><!--end /menu-li -->
			<!-- END FORMS -->

			<!-- BEGIN CHARTS -->
			<li>
				<a href="{{ url('datatables') }}" >
					<div class="gui-icon"><i class="md md-assessment"></i></div>
					<span class="title">Charts</span>
				</a>
			</li><!--end /menu-li -->
			<!-- END CHARTS -->


		</ul><!--end .main-menu -->
		<!-- END MAIN MENU -->

		<div class="menubar-foot-panel">
			<small class="no-linebreak hidden-folded">
				<span class="opacity-75">Copyright &copy; 2016</span> <strong>Life is Strange</strong>
			</small>
		</div>
	</div><!--end .menubar-scroll-panel-->
</div><!--end #menubar-->
<!-- END MENUBAR -->