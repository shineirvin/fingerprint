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

.file-upload-wrapper {
		position: relative;
		z-index: 5;
		display: block;
		width: 250px;
		height: 30px;
		margin: 5px auto;
		border-right: 3px dotted rgb(33, 122, 105);
		border-bottom: 3px dotted rgb(33, 122, 105);
		border-left: 3px dotted rgb(33, 122, 105);
}

.file-upload-native,
.file-upload-text {
		position: absolute;
		top: 0;
		left: 0;
		display: block;
		width: 100%;
		height: 100%;
		cursor: pointer;
}

input[type="file"]::-webkit-file-upload-button {
		cursor: pointer;
}

.file-upload-native:focus,
.file-upload-text:focus {
		outline: none;
}

.file-upload-text {
		z-index: 10;
		padding: 5px 15px 8px;
		overflow: hidden;
		font-size: 14px;
		line-height: 1.4;
		cursor: pointer;
		text-align: center;
		letter-spacing: 1px;
		text-overflow: ellipsis;
		color: rgb(144, 162, 148);
		border: 0;
		background-color: transparent;
}

.file-upload-native {
		z-index: 15;
		opacity: 0;
}

.img-backdrop {
background-image: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ), url('materialadmin/assets/img/tarumanagara.jpg');

}
</style>

<div id="content">

				<!-- BEGIN PROFILE HEADER -->
				<section class="full-bleed">
					<div class="section-body style-default-dark force-padding text-shadow">
						<div class="img-backdrop">
						</div>
						<div class="overlay overlay-shade-top stick-top-left height-3"></div>
						<div class="row">
							<div class="col-md-3 col-xs-5"> 
									<div class="preview img-wrapper "></div>
									<div class="file-upload-wrapper">
									{!! Form::open(['method' => 'POST', 'files'=> true, 'url'=>'profile/picture']) !!}
											<input type="file" name="file" class="file-upload-native" accept="image/*"/>
											<input type="text" disabled placeholder="Choose image" class="file-upload-text" />
											<button type="submit" class="btn ink-reaction btn-raised btn-primary" style="width: 100%; margin-top: 20%;"> Upload! </button>
									{!! Form::close() !!}
									</div>
									<br><br>
								<h3>{{ Auth::user()->name }}<br/><small>{{ Auth::user()->roles }} at Tarumanagara University</small></h3>
							</div><!--end .col -->
						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
				<!-- END PROFILE HEADER  -->

				<section>
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-lg-offset-2 col-md-8">
								{!! Form::open(['method' => 'PUT','url'=>'/profile/changepassword']) !!}
									<div class="card">
										<div class="card-head style-primary">
											<header>Change Password</header>
										</div>
										<div class="card-body">
											<br/>
											<div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
												<label for="oldpassword">Old Password</label>
												<input type="password" class="form-control" id="oldpassword" name="oldpassword">
		                                        @if ($errors->has('oldpassword'))
		                                            <span class="help-block">
		                                                <strong>{{ $errors->first('oldpassword') }}</strong>
		                                            </span>
		                                        @endif
											</div>
											<div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
												<label for="newpassword">New Password</label>
												<input type="password" class="form-control" id="newpassword" name="newpassword">
		                                        @if ($errors->has('newpassword'))
		                                            <span class="help-block">
		                                                <strong>{{ $errors->first('newpassword') }}</strong>
		                                            </span>
		                                        @endif
											</div>
											<div class="form-group{{ $errors->has('cpassword') ? ' has-error' : '' }}">
												<label for="cpassword">Password Confirmation</label>
												<input type="password" class="form-control" id="cpassword" name="cpassword">
		                                        @if ($errors->has('cpassword'))
		                                            <span class="help-block">
		                                                <strong>{{ $errors->first('cpassword') }}</strong>
		                                            </span>
		                                        @endif
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar">
											<div class="card-actionbar-row">
												<button type="submit" class="btn btn-flat btn-primary ink-reaction">Change Password</button>
											</div>
										</div>
									</div><!--end .card -->
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</section>

<script>
$(function() {
	function maskImgs() {
		$.each($('.img-wrapper img'), function(index, img) {
			var src = $(img).attr('src');
			var parent = $(img).parent();
			parent
				.css('background', 'url(' + src + ') no-repeat center center')
				.css('background-size', 'cover');
			$(img).remove();
		});
	}

	var preview = {
		init: function() {
			preview.setPreviewImg();
			preview.listenInput();
		},
		setPreviewImg: function(fileInput) {
			var path = $(fileInput).val();
			var uploadText = $(fileInput).siblings('.file-upload-text');

			if (!path) {
				$(uploadText).val('');
			} else {
				path = path.replace(/^C:\\fakepath\\/, "");
				$(uploadText).val(path);

				preview.showPreview(fileInput, path, uploadText);
			}
		},
		showPreview: function(fileInput, path, uploadText) {
			var file = $(fileInput)[0].files;

			if (file && file[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					var previewImg = $(fileInput).parents('.file-upload-wrapper').siblings('.preview');
					var img = $(previewImg).find('img');

					if (img.length == 0) {
						$(previewImg).html('<img src="' + e.target.result + '" alt=""/>');
					} else {
						img.attr('src', e.target.result);
					}

					uploadText.val(path);
					maskImgs();
				}

				reader.onloadstart = function() {
					$(uploadText).val('uploading..');
				}

				reader.readAsDataURL(file[0]);
			}
		},
		listenInput: function() {
			$('.file-upload-native').on('change', function() {
				preview.setPreviewImg(this);
			});
		}
	};
	preview.init();
});
</script>

</div>

@endsection