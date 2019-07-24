@section('title', $data['title'])
@section('subtitle', $data['subtitle'])

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'APP') }} LS - (Version {{ config('app.version', 'X') }})</title>
  <link rel="icon" href="{{{ asset('img/favicon.ico') }}}" type="image/ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{{ asset('adminlte/css/AdminLTE.min.css') }}}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="{{{ asset('adminlte/css/skins/skin-blue.min.css') }}}">

  <link rel="stylesheet" href="{{{ asset('adminlte/css/myStile.css') }}}">

  <link rel="stylesheet" href="{{{ asset('adminlte/css/toastr.min.css') }}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!--
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  -->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.navbar.top')
    @include('admin.navbar.left')
  
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        @yield('title') <small>@yield('subtitle')</small>
      @yield('cabecera_adicional')
      </h1>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('admin.footer')
  @include('admin.sidebarControl')
</div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 3 -->
  <script src="{{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}}"></script>
  <!-- AdminLTE App -->
  <script src="{{{ asset('adminlte/js/adminlte.min.js') }}}"></script>
  <!-- ToasTR.js -->
  <script src="{{{ asset('adminlte/js/toastr.min.js') }}}"></script>

  @yield('listadoJS')
  <!--
    Optionally, you can add Slimscroll and FastClick plugins.
    Both of these plugins are recommended to enhance the
    user experience.
  -->
</body>
</html>