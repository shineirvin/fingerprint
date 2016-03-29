<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Material Admin - Login</title>

        <!-- BEGIN META -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="your,keywords">
        <meta name="description" content="Short explanation about this website">
        <!-- END META -->

        <!-- BEGIN STYLESHEETS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
        <link type="text/css" rel="stylesheet" href="materialadmin/assets/css/theme-default/bootstrap.css?1422792965" />
        <link type="text/css" rel="stylesheet" href="materialadmin/assets/css/theme-default/materialadmin.css?1425466319" />
        <link type="text/css" rel="stylesheet" href="materialadmin/assets/css/theme-default/font-awesome.min.css?1422529194" />
        <link type="text/css" rel="stylesheet" href="materialadmin/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
        <!-- END STYLESHEETS -->
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN LOGIN SECTION -->
        <section class="section-account">
            <div class="img-backdrop" style="background-image: url('materialadmin/assets/img/img16.jpg')"></div>
            <div class="spacer"></div>
            <div class="card contain-sm style-transparent">
                <div class="card-body">
                    <div class="col-sm-15">
                        <br/>
                        <span class="text-lg text-bold text-primary">Register User</span>
                        <br/><br/>
                        <div class="card">
                        <div class="card-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                {!! Form::select('roles', [
                                    '' => 'Please select the role' ,
                                    'Admin' => 'Admin',
                                    'Dosen' => 'Dosen',
                                    'Mahasiswa' => 'Mahasiswa'], null,  array('class'=>'form-control', 'id'=>'roles'))
                                !!}
                            </div> <br> <br> <br>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="username">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="name">         
                                    @if ($errors->has('name'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div> <br>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">NIM / NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username">
                                    @if ($errors->has('username'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div> <br>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">E-mail Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" name="email">
                                    @if ($errors->has('email'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div> <br>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password">
                                    @if ($errors->has('password'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div> <br>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    @if ($errors->has('password_confirmation'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </p>
                                    @endif
                                </div> <br>
                                <p class="help-block" style="text-decoration: underline;"><a href="{{ url('/') }}">Back to login page</a></p>
                            </div>
                            <br/>

                                <div class="col-xs-13 text-center">
                                    <button class="btn btn-primary btn-raised" type="submit">Register</button>
                                </div><!--end .col -->
                        </form>
                        </div>
                        </div>
                    </div><!--end .col -->

                </div><!--end .card-body -->
            </div><!--end .card -->
        </section>
        <!-- END LOGIN SECTION -->

                <!-- BEGIN JAVASCRIPT -->
                <script src="materialadmin/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
                <script src="materialadmin/assets/js/core/source/App.js"></script>
                <script src="materialadmin/assets/js/core/source/AppNavigation.js"></script>
                <script src="materialadmin/assets/js/core/source/AppOffcanvas.js"></script>
                <script src="materialadmin/assets/js/core/source/AppCard.js"></script>
                <script src="materialadmin/assets/js/core/source/AppForm.js"></script>
                <script src="materialadmin/assets/js/core/source/AppNavSearch.js"></script>
                <script src="materialadmin/assets/js/core/source/AppVendor.js"></script>
                <!-- END JAVASCRIPT -->

            </body>
        </html>
