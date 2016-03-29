@extends ('layouts.app1')

@section ('content')

<div id="app">
	<div id="content">
		<section>
			<div class="section-header">
				<ol class="breadcrumb">
					<li class="active"> XML to Json </li>
				</ol>
			</div>
			<div class="section-body contain-lg">

	<label class="radio-inline"><input type="radio" name="optradio" v-model="picked" value="xmltojson" checked>XML to Json</label>
	<label class="radio-inline"><input type="radio" name="optradio" v-model="picked" value="jsontoxml">Json to XML</label>

				<!-- BEGIN INTRO -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="text-primary">Practicing from XML to Json with PHP</h1>
					</div><!--end .col -->
					<div class="col-lg-5">
						<article class="margin-bottom-xxl">
							<form class="form floating-label" role="form" method="POST" action="{{ url('/practice') }}">
							{!! csrf_field() !!}
							    <div class="form-group">
		                            <textarea type="text" class="form-control" id="xml" name="xml" style="height: 400px" :disabled="picked == 'jsontoxml' "> </textarea>
		                            <label for="xml"> Insert Your XML</label>
		                        </div>
						</article>
					</div><!--end .col -->
					<div class="col-lg-2" style="margin-top: 200px; padding-left: 50px;">
						<button type="submit" class="btn btn-primary"> <i class="fa fa-arrow-right fa-5x"></i> </button>
					</div>
					<div class="col-lg-5">
						<article class="margin-bottom-xxl">
							<div class="form floating-label">
							    <div class="form-group">
		                            <textarea type="text" class="form-control" id="json" name="json" style="height: 400px" :disabled="picked == 'xmltojson' ">  {{ $tests }} </textarea>
		                            <label for="json"> Json Output </label>
		                        </div>
		                    </div>
	                        </form>
						</article>
					</div><!--end .col -->
				</div><!--end .row -->
				<!-- END INTRO -->
			</div>
		</section>
	</div>
</div>

<script>
	new Vue({
	  el: '#app',
	  data: {
	    picked: ''
	  }
	})	
</script>


@endsection