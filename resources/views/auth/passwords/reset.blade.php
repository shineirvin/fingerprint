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

        <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/bootstrap.css') !!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/materialadmin.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/font-awesome.min.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/material-design-iconic-font.min.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/jquery.dataTables.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/css/buttons.dataTables.min.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('materialadmin/assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/dist/sweetalert.css')!!}"/>
        <link type="text/css" rel="stylesheet" href="{!! url('assets/sweetalert-master/themes/twitter/twitter.css')!!}"/>
        <script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-1.11.2.min.js')!!}"></script>

    </head>
    <body class="menubar-hoverable header-fixed ">
    <br> <br> <br> <br> <br> <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="text-lg text-bold text-primary">Reset Password</span></div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                            {!! csrf_field() !!}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-refresh"></i> Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>