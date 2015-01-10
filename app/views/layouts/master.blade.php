<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Magman - Fumetti
      @if(isset($title))
        - {{ $title }}
      @endif
    </title>
    <!-- BOOTSTRAP STYLES-->
    <link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{ URL::asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="{{ URL::asset('assets/js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
  </head>

  <body>

    <div id="wrapper">
      <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="index.html"><img src="{{ URL::asset('assets/img/logo.png') }}" class="img-responsive"/></a>

      </div>

      <div style="color: white; padding: 20px 50px 5px 50px; float: right; font-size: 16px;">
        Benvenuto <a href="{{ URL::asset('profile') }}">{{Auth::user()->name}}</a>! &nbsp; <a href="logout" class="btn btn-danger square-btn-adjust">Logout</a>
      </div>
      </nav>
      <!-- /. NAV TOP  -->


      <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
          <ul class="nav" id="main-menu">
            <li class="red-line">
            </li>
            <li>
              <a  href="{{ URL::asset('home') }}"><i class="fa fa-dashboard fa-3x sidebar-icon"></i> Dashboard</a>
            </li>
            @if(Auth::user()->level_id == 1)
            <li  >
              <a  href="{{ URL::asset('newShipment') }}"><i class="fa fa-plus-square fa-3x sidebar-icon"></i> Nuovi Arrivi</a>
            </li>
            <li>
              <a  href="{{ URL::asset('boxes') }}"><i class="fa fa-user fa-3x sidebar-icon"></i> Caselle</a>
            </li>
            <li>
              <a  href="{{ URL::asset('comics') }}"><i class="fa fa-book fa-3x sidebar-icon"></i> Fumetti</a>
            </li>
            @endif
            @if(Auth::user()->level_id == 2)
            <li>
              <a  href="{{ URL::asset('box') }}"><i class="fa fa-user fa-3x sidebar-icon"></i> Casella</a>
            </li>
            @endif
            <li  >
              <a  href="{{ URL::asset('series') }}"><i class="fa fa-th-large fa-3x sidebar-icon"></i> Serie</a>
            </li>
            @if(Auth::user()->level_id == 100)
            <li>
              <a href="#"><i class="fa fa-gear fa-3x sidebar-icon"></i> Gestione parametri fissi<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <li>
                  <a href="#">Second Level Link</a>
                </li>
                <li>
                  <a href="#">Second Level Link</a>
                </li>
                <li>
                  <a href="#">Second Level Link<span class="fa arrow"></span></a>
                  <ul class="nav nav-third-level">
                    <li>
                      <a href="#">Third Level Link</a>
                    </li>
                    <li>
                      <a href="#">Third Level Link</a>
                    </li>
                    <li>
                      <a href="#">Third Level Link</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
      </nav>
      <!-- /. NAV SIDE  -->


      <div id="page-wrapper" >
        <div id="page-inner">

          <div class="row">
            <div class="col-md-12">
              @yield('content')

            </div>
          </div>
          <!-- /. ROW  -->
        </div>
        <!-- /. PAGE INNER  -->
      </div>
      <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
  </body>
</html>
