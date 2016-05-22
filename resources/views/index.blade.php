@extends ('layouts.app1')

@section ('content')

<!-- BEGIN CONTENT-->
<div id="content">
	<section>
		<div class="section-header">
			<ol class="breadcrumb">
				<li class="active">Dashboard</li>
			</ol>
		</div>
		<div class="section-body contain-lg">

			<!-- BEGIN INTRO -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-primary">Hello {{ Auth::user()->name }}</h1>
				</div><!--end .col -->
				<div class="col-lg-8">
					<article class="margin-bottom-xxl">
						<p class="lead">
							Basic form elements are text fields that allow the user to input text or select a value.
							They can be single line or multi-line, and can have an icon.
						</p>
					</article>
				</div><!--end .col -->
			</div><!--end .row -->
			<!-- END INTRO -->
		</div>
	</section>
</div>

@endsection