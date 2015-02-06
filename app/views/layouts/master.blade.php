<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>
          Magman - Fumetti
          @if(isset($title))
              - {{ $title }}
          @endif
      </title>
      <!-- BOOTSTRAP STYLES-->
      <link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet"/>
      <!-- FONTAWESOME STYLES-->
      <link href="{{ URL::asset('assets/css/font-awesome.css') }}" rel="stylesheet"/>
      <!-- CUSTOM STYLES-->
      <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet"/>
      <!-- OUR STYLES-->
      <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet"/>
      <!-- GOOGLE FONTS-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
      <!-- TABLE STYLES-->
      <link href="{{ URL::asset('assets/js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet"/>
  </head>

  <body>

  <div id="wrapper">

    @include('layouts/navtop')

    @include('layouts/navbar')

    <div id="page-wrapper">
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
  <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
  <!-- JQUERY SCRIPTS -->
  <script src="../../../assets/js/jquery.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="../../../assets/js/bootstrap.min.js"></script>
  <!-- METISMENU SCRIPTS -->
  <script src="../../../assets/js/jquery.metisMenu.js"></script>
  <!-- DATA TABLE SCRIPTS -->
  <script src="../../../assets/js/dataTables/jquery.dataTables.js"></script>
  <script src="../../../assets/js/dataTables/dataTables.bootstrap.js"></script>
  <script src= {{ URL::asset('assets/js/control.js') }}></script>
  <script src= {{ URL::asset('assets/js/custom.js') }}></script>
  </body>
</html>
