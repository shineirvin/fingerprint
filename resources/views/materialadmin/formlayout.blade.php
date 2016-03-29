@extends ('layouts.app1')

@section ('content')

<div id="content">
	<!-- BEGIN LIST SAMPLES -->
	<section>
		<div class="section-header">
			<ol class="breadcrumb">
				<li class="active">Form Title </li>
			</ol>
		</div>
		<div class="section-body contain-lg">

			<!-- BEGIN INTRO -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-primary">Layouts</h1>
				</div><!--end .col -->
				<div class="col-lg-8">
					<article class="margin-bottom-xxl">
						<p class="lead">
							Material Admin has several layout options that can be used for different purposes.
							You can either choose between a full-width header or a full-height menubar.
						</p>
						<p class="lead">
							Pin the menubar if you want to start with an expanded menubar.
							When you choose an expanded menubar, it will automatically collapse on smaller screens.
						</p>
					</article>
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END INTRO -->

			<!-- BEGIN TILE CONTENT -->
			<div class="row">
				<div class="col-lg-12">
					<h2 class="text-primary">Content</h2>
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END TILE CONTENT -->

			<!-- BEGIN LAYOUT - HEADER FULL WIDTH -->
			<div class="row">
				<div class="col-lg-12">
					<h4>Full-width header</h4>
				</div>
			</div><!--end .row -->
			<div class="row">
				<div class="col-lg-3 col-md-4  col-sm-12">
					<article class="margin-bottom-xxl">
						<p>
							In this layout, the header extends over the entire width of the screen.
							Below the header is the menubar.
						</p>
					</article>
				</div><!--end .col -->
				<div class="col-lg-offset-1 col-md-4 col-sm-6">
					<div class="card card-outlined style-accent">
						<div class="card-body no-padding card-tiles style-default-light">
							<div class="height-1 style-default-bright"></div>
							<div class="row">
								<div class="col-xs-3">
									<div class="height-5 style-gray-bright"></div>
								</div>
								<div class="col-xs-9"></div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton disabled" data-layout="1">Activated</a>
						<ul class="text-caption">
							<li>Expanded menubar</li>
							<li><strong>Full-width header</strong></li>
							<li>Fixed header</li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
				<div class="col-md-4 col-sm-6">
					<div class="card card-outlined style-default-bright">
						<div class="card-body no-padding card-tiles style-default-light">
							<div class="height-1 style-default-bright"></div>
							<div class="row">
								<div class="col-xs-1">
									<div class="height-5 style-gray-bright"></div>
								</div>
								<div class="col-xs-11"></div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton" data-layout="2">Activate</a>
						<ul class="text-caption">
							<li>Collapsed menubar</li>
							<li><strong>Full-width header</strong></li>
							<li>Fixed header</li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END LAYOUT - HEADER FULL WIDTH -->

			<!-- BEGIN LAYOUT - MENUBAR FULL HEIGHT -->
			<div class="row">
				<div class="col-lg-12">
					<h4>Full-height menubar</h4>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-12">
					<article class="margin-bottom-xxl">
						<p>
							In this layout, the menubar extends over the entire height of the screen.
						</p>
					</article>
				</div><!--end .col -->
				<div class="col-lg-offset-1 col-md-4 col-sm-6">
					<div class="card card-outlined style-default-bright">
						<div class="card-body no-padding card-tiles style-default-light">
							<div class="row">
								<div class="col-xs-3">
									<div class="height-6 style-gray-bright"></div>
								</div>
								<div class="col-xs-9">
									<div class="height-1 style-default-bright"></div>
								</div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton" data-layout="3">Activate</a>
						<ul class="text-caption">
							<li>Expanded menubar</li>
							<li><strong>Full-height menubar</strong></li>
							<li>Fixed header</li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
				<div class="col-md-4 col-sm-6">
					<div class="card card-outlined style-default-bright">
						<div class="card-body no-padding card-tiles style-default-light">
							<div class="row">
								<div class="col-xs-1">
									<div class="height-6 style-gray-bright"></div>
								</div>
								<div class="col-xs-11">
									<div class="height-1 style-default-bright"></div>
								</div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton" data-layout="4">Activate</a>
						<ul class="text-caption">
							<li>Collapsed menubar</li>
							<li><strong>Full-height menubar</strong></li>
							<li>Fixed header</li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END LAYOUT - MENUBAR FULL HEIGHT -->

			<!-- BEGIN LAYOUT - STATIC HEADER -->
			<div class="row">
				<div class="col-lg-12">
					<h4>Static header</h4>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-12">
					<article class="margin-bottom-xxl">
						<p>
							If you do not want to have a fixed header, you simpe remove the <code>.header-fixed</code> class.
						</p>
					</article>
				</div><!--end .col -->
				<div class="col-lg-offset-1 col-md-4 col-sm-6">
					<div class="card card-outlined style-default-bright">
						<div class="card-body no-padding card-tiles style-gray-bright">
							<div class="row">
								<div class="col-xs-3"></div>
								<div class="col-xs-9 ">
									<div class="border-black border-dashed"><div class="style-default-bright height-1"></div></div>
									<div class="height-5 style-default-light"></div>
								</div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton" data-layout="5">Activate</a>
						<ul class="text-caption">
							<li>Expanded menubar</li>
							<li>Full-height menubar</li>
							<li><strong>Static header</strong></li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
				<div class="col-md-4 col-sm-6">
					<div class="card card-outlined style-default-bright">
						<div class="card-body no-padding card-tiles style-gray-bright">
							<div class="row">
								<div class="col-xs-1"></div>
								<div class="col-xs-11 ">
									<div class="border-black border-dashed"><div class="style-default-bright height-1"></div></div>
									<div class="height-5 style-default-light"></div>
								</div>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
					<div class="text-caption holder">
						<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction stick-top-right layoutButton" data-layout="6">Activate</a>
						<ul class="text-caption">
							<li>Collapsed menubar</li>
							<li>Full-height menubar</li>
							<li><strong>Static header</strong></li>
						</ul>
					</div><!--end .holder -->
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END LAYOUT - STATIC HEADER -->

		</div><!--end .section-body -->
	</section>
</div><!--end #content-->


@endsection