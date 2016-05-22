<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Material Admin - Layouts</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">

		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/bootstrap.css') !!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/materialadmin.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/font-awesome.min.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/material-design-iconic-font.min.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/jquery.dataTables.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/css/buttons.dataTables.min.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/dist/sweetalert.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/themes/twitter/twitter.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/select2/select2.css')!!}"/>

		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/js/libs/bootstrap-clockpicker/bootstrap-clockpicker.min.css')!!}"/>

		<script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-1.11.2.min.js')!!}"></script>

	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">


	@include ('materialadmin.header')

		<div id="base">

		<div class="offcanvas"> </div>


			@yield('content')	

			@include ('materialadmin.sidebar')


		</div>
		
		<script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js')!!}"></script>
		<script src="{!! url('assets/sweetalert-master/dist/sweetalert-dev.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/bootstrap/bootstrap.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/bootstrap-clockpicker/bootstrap-clockpicker.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/select2/select2.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/spin.js/spin.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/autosize/jquery.autosize.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/jquery.dataTables.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/dataTables.buttons.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/jszip.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/pdfmake.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/buttons.html5.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/vfs_fonts.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/App.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppNavigation.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppOffcanvas.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppCard.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppForm.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppNavSearch.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppVendor.js')!!}"></script>

		@yield('intJS')

		@include('flash')
	</body>
</html>
