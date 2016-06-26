@extends ('layouts.app1')

@section ('content')

<style>
*,
*::after,
*::before {
		padding: 0;
		margin: 0;
		box-sizing: border-box;
}


.preview {
		display: block;
		width: 146px;
		height: 146px;
		margin: 20px auto;
		border: 3px solid rgb(33, 122, 105);
		border-radius: 50%;
		overflow: hidden;
		background: url(
			@if($user->fhoto)
				{{ $user->fhoto }}
			@else
				'materialadmin/assets/img/avatar1.jpg?1403934956'
			@endif
			) no-repeat;
		background-size: 146px 146px;
	    background-position: center;

}



.file-upload-native,
.file-upload-text {
		position: absolute;
		top: 0;
		left: 0;
		display: block;
		width: 100%;
		height: 100%;
		cursor: default;
}

input[type="file"]::-webkit-file-upload-button {
		cursor: pointer;
}

.file-upload-native:focus,
.file-upload-text:focus {
		outline: none;
}



.file-upload-native {
		z-index: 15;
		opacity: 0;
}

.img-backdrop {
background-image: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ), url('materialadmin/assets/img/tarumanagara.jpg');

}
</style>

<!-- BEGIN CONTENT-->
<div id="content">

				<section class="full-bleed">
					<div class="section-body style-default-dark force-padding text-shadow">
						<div class="img-backdrop">
						</div>
						<div class="overlay overlay-shade-top stick-top-left height-3"></div>
						<div class="row">
							<div class="col-md-3 col-xs-5"> 
									<div class="preview img-wrapper "></div>
									<div class="file-upload-wrapper">
											<input  name="file" class="file-upload-native" accept="image/*"/>
									</div>
									<br><br>
								<h3>Hello, {{ Auth::user()->name }} !<br/><small> {{ Auth::user()->roles }} at Tarumanagara University</small></h3>
							</div><!--end .col -->
						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>

</div>


@endsection