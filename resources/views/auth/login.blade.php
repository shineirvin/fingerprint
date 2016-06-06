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
                    <div class="row">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-6">
                            <br/>
                            <span class="text-lg text-bold text-primary">UNIVERSITAS TARUMANAGARA</span>
                            <h3 class="text-light">
                                Log In
                            </h3>
                            <form class="form default-label" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}
                                <div class="form-group">
                                    <input type="username" class="form-control" id="username" name="username">
                                    <label for="username">Username</label>
                                @if ($errors->has('username'))
                                    <p class="help-blockleft">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </p>
                                @endif
                                </div>
                                <div class="form-group">
                                	<input type="password" class="form-control" id="password1" name="password">
									<label for="password1">Password</label>
                                    @if ($errors->has('password'))
                                        <p class="help-blockleft">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </p>
                                    @endif
                                    <p class="help-block"><a href="{{ url('password/reset') }}">Forgotten?</a></p>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        <div class="checkbox checkbox-inline checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="remember"> <span>Remember me</span>
                                            </label>
                                        </div>
                                    </div><!--end .col -->
                                    <div class="col-xs-6 text-right">
                                        <button class="btn btn-primary btn-raised" type="submit">Login</button>
                                    </div><!--end .col -->
                                </div><!--end .row -->
                            </form>
                        </div><!--end .col -->
                    </div><!--end .row -->
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
