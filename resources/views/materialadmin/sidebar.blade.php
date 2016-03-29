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

			<!-- BEGIN PAGES -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="md md-computer"></i></div>
					<span class="title">Pages</span>
				</a>
				<!--start submenu -->
				<ul>
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Contacts</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="materialadmin/html/pages/contacts/search.html" ><span class="title">Search</span></a></li>
							<li><a href="materialadmin/html/pages/contacts/details.html" ><span class="title">Contact card</span></a></li>
							<li><a href="materialadmin/html/pages/contacts/add.html" ><span class="title">Insert contact</span></a></li>
						</ul><!--end /submenu -->
					</li><!--end /menu-li -->
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Search</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="materialadmin/html/pages/search/results-text.html" ><span class="title">Results - Text</span></a></li>
							<li><a href="materialadmin/html/pages/search/results-text-image.html" ><span class="title">Results - Text and Image</span></a></li>
						</ul><!--end /submenu -->
					</li><!--end /menu-li -->
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Blog</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="materialadmin/html/pages/blog/masonry.html" ><span class="title">Blog masonry</span></a></li>
							<li><a href="materialadmin/html/pages/blog/list.html" ><span class="title">Blog list</span></a></li>
							<li><a href="materialadmin/html/pages/blog/post.html" ><span class="title">Blog post</span></a></li>
						</ul><!--end /submenu -->
					</li><!--end /menu-li -->
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Error pages</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="materialadmin/html/pages/404.html" ><span class="title">404 page</span></a></li>
							<li><a href="materialadmin/html/pages/500.html" ><span class="title">500 page</span></a></li>
						</ul><!--end /submenu -->
					</li><!--end /menu-li -->
					<li><a href="materialadmin/html/pages/profile.html" ><span class="title">User profile<span class="badge style-accent">42</span></span></a></li>
					<li><a href="materialadmin/html/pages/invoice.html" ><span class="title">Invoice</span></a></li>
					<li><a href="materialadmin/html/pages/calendar.html" ><span class="title">Calendar</span></a></li>
					<li><a href="materialadmin/html/pages/pricing.html" ><span class="title">Pricing</span></a></li>
					<li><a href="materialadmin/html/pages/timeline.html" ><span class="title">Timeline</span></a></li>
					<li><a href="materialadmin/html/pages/maps.html" ><span class="title">Maps</span></a></li>
					<li><a href="materialadmin/html/pages/locked.html" ><span class="title">Lock screen</span></a></li>
					<li><a href="materialadmin/html/pages/login.html" ><span class="title">Login</span></a></li>
					<li><a href="materialadmin/html/pages/blank.html" ><span class="title">Blank page</span></a></li>
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

			<!-- BEGIN LEVELS -->
			<li class="gui-folder">
				<a>
					<div class="gui-icon"><i class="fa fa-folder-open fa-fw"></i></div>
					<span class="title">Menu levels demo</span>
				</a>
				<!--start submenu -->
				<ul>
					<li><a href="#"><span class="title">Item 1</span></a></li>
					<li><a href="#"><span class="title">Item 1</span></a></li>
					<li class="gui-folder">
						<a href="javascript:void(0);">
							<span class="title">Open level 2</span>
						</a>
						<!--start submenu -->
						<ul>
							<li><a href="#"><span class="title">Item 2</span></a></li>
							<li class="gui-folder">
								<a href="javascript:void(0);">
									<span class="title">Open level 3</span>
								</a>
								<!--start submenu -->
								<ul>
									<li><a href="#"><span class="title">Item 3</span></a></li>
									<li><a href="#"><span class="title">Item 3</span></a></li>
									<li class="gui-folder">
										<a href="javascript:void(0);">
											<span class="title">Open level 4</span>
										</a>
										<!--start submenu -->
										<ul>
											<li><a href="#"><span class="title">Item 4</span></a></li>
											<li class="gui-folder">
												<a href="javascript:void(0);">
													<span class="title">Open level 5</span>
												</a>
												<!--start submenu -->
												<ul>
													<li><a href="#"><span class="title">Item 5</span></a></li>
													<li><a href="#"><span class="title">Item 5</span></a></li>
												</ul><!--end /submenu -->
											</li><!--end /submenu-li -->
										</ul><!--end /submenu -->
									</li><!--end /submenu-li -->
								</ul><!--end /submenu -->
							</li><!--end /submenu-li -->
						</ul><!--end /submenu -->
					</li><!--end /submenu-li -->
				</ul><!--end /submenu -->
			</li><!--end /menu-li -->
			<!-- END LEVELS -->

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