@extends ('layouts.app1')

@section ('content')
	
	<div id="content">
	<br>
				<section>
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-lg-offset-2 col-md-8">
								<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
			                        {!! csrf_field() !!}
			                        {!! Form::hidden('roles', 'Mahasiswa') !!}
								<div class="card">
										<div class="card-head style-primary">
											<header>Daftar mahasiswa baru</header>
										</div>
									<div class="card-body">

			                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			                                <label class="col-sm-2 control-label" for="username">Name</label>
			                                <div class="col-sm-10">
			                                    <input type="text" class="form-control" id="username" name="name" value="{{ old('name') }}">         
			                                    @if ($errors->has('name'))
			                                        <p class="help-blockleft">
			                                            <strong>{{ $errors->first('name') }}</strong>
			                                        </p>
			                                    @endif
			                                </div>
			                            </div> <br>
			                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
			                                <label for="username" class="col-sm-2 control-label">NIM / NIK</label>
			                                <div class="col-sm-10">
			                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
			                                    @if ($errors->has('username'))
			                                        <p class="help-blockleft">
			                                            <strong>{{ $errors->first('username') }}</strong>
			                                        </p>
			                                    @endif
			                                </div>
			                            </div> <br>
			                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			                                <label for="email" class="col-sm-2 control-label">E-mail Address</label>
			                                <div class="col-sm-10">
			                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
			                                    @if ($errors->has('email'))
			                                        <p class="help-blockleft">
			                                            <strong>{{ $errors->first('email') }}</strong>
			                                        </p>
			                                    @endif
			                                </div>
			                            </div> <br>
			                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			                                <label for="password" class="col-sm-2 control-label">Password</label>
			                                <div class="col-sm-10">
			                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
			                                    @if ($errors->has('password'))
			                                        <p class="help-blockleft">
			                                            <strong>{{ $errors->first('password') }}</strong>
			                                        </p>
			                                    @endif
			                                </div>
			                            </div> <br>
			                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
			                                <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
			                                <div class="col-sm-10">
			                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
			                                    @if ($errors->has('password_confirmation'))
			                                        <p class="help-blockleft">
			                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
			                                        </p>
			                                    @endif
											</div>
										</div>
									</div><!--end .card-body -->
										<div class="card-actionbar">
											<div class="card-actionbar-row">
												<button type="submit" class="btn btn-flat btn-primary ink-reaction">Register</button>
											</div>
										</div>
								</div><!--end .card -->
			                        </form>
							</div>
						</div>
					</div>
				</section>

@endsection