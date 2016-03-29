<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Material Admin - Layouts</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/bootstrap.css') !!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/materialadmin.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/font-awesome.min.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/material-design-iconic-font.min.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/jquery.dataTables.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/dist/sweetalert.css')!!}"/>
		<link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/themes/twitter/twitter.css')!!}"/>
		<script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-1.11.2.min.js')!!}"></script>
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="materialadmin/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="materialadmin/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">


	@include ('materialadmin.header')

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN OFFCANVAS LEFT -->
			<div class="offcanvas">
			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS LEFT -->


			<!-- BEGIN CONTENT-->
				@yield('content')	
			<!-- END CONTENT -->

			<!-- BEGIN MENUBAR-->
				@include ('materialadmin.sidebar')
			<!-- END MENUBAR -->


		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		
		<script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js')!!}"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.min.js"></script>
		<script src="{!! url('assets/sweetalert-master/dist/sweetalert-dev.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/bootstrap/bootstrap.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/spin.js/spin.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/autosize/jquery.autosize.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/jquery.dataTables.min.js')!!}"></script>
<!-- 		<script src="materialadmin/assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script> -->
		<script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/App.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppNavigation.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppOffcanvas.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppCard.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppForm.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppNavSearch.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppVendor.js')!!}"></script>
		<script src="{!! url('materialadmin/assets/js/core/source/AppVendor.js')!!}"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>
