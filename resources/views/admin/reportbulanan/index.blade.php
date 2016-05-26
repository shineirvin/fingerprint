@extends ('layouts.app1')

@section ('content')

	<div id="content"> <br><br>
				<section>
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-lg-offset-2 col-md-8">
									<div class="card">
										<div class="card-head style-primary">
											<header>Rekap Bulanan Dosen</header>
										</div>
										<div class="card-body">
											<br>
											<div class="form-group">
												<div class="input-daterange input-group" id="datepicker">
													<div class="input-group-content">
														<input type="text" class="form-control" name="start" id="start">
														<label>Date range</label>
													</div>
													<span class="input-group-addon">to</span>
													<div class="input-group-content">
														<input type="text" class="form-control" name="end" id="end">
														<div class="form-control-line"></div>
													</div>
												</div>
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar">
											<div class="card-actionbar-row">
												<button type="submit" id="redirect" class="btn btn-flat btn-primary ink-reaction">Cari</button>
											</div>
										</div>
									</div><!--end .card -->
							</div>
						</div>
					</div>
				</section>

<script>
	$( "#redirect" ).click(function() {
		var start = $( "#start" ).val();
		var startday = start.slice(0,2);
		var startmonth = start.slice(3,5);
		var startyear = start.slice(6,10);
		var startdate = startday + startmonth + startyear;
		var end = $( "#end" ).val();
		var endday = end.slice(0,2);
		var endmonth = end.slice(3,5);
		var endyear = end.slice(6,10);
		var enddate = endday + endmonth + endyear;
		window.location = 'reportBulanan/' + startdate + '/' + enddate;
	});
</script>

@endsection