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
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                {!! csrf_field() !!}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                    <br>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-md-offset-4">
                                        <a href="{!! url('login') !!}" class="btn btn-primary" style="margin-top: 10px; width: 74%;"> Back to the login page </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{!! url('materialadmin/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js')!!}"></script>
        <script src="{!! url('assets/sweetalert-master/dist/sweetalert-dev.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/bootstrap/bootstrap.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/spin.js/spin.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/autosize/jquery.autosize.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/jquery.dataTables.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/dataTables.buttons.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/jszip.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/pdfmake.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/buttons.html5.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/DataTables/extensions/Button/js/vfs_fonts.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/App.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppNavigation.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppOffcanvas.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppCard.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppForm.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppNavSearch.js')!!}"></script>
        <script src="{!! url('materialadmin/assets/js/core/source/AppVendor.js')!!}"></script>

    </body>
</html>