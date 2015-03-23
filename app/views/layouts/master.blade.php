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
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", rel="stylesheet"/>
      <!-- BOOTSTRAP SELECTIZE STYLES MOD BY TOMU-->
      <link href="{{ URL::asset('assets/css/selectize.bootstrap3.css') }}" rel="stylesheet"/>
      <!-- CUSTOM STYLES-->
      <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet"/>
      <!-- OUR STYLES-->
      <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet"/>
      <!-- GOOGLE FONTS-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
      <!-- TABLE STYLES-->
      <link href="{{ URL::asset('assets/css/dataTables/jquery.dataTables.css') }}" rel="stylesheet"/>
      <link href="{{ URL::asset('assets/js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet"/>
      <!-- RESPONSIVE TABLE-->
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
  </body>
</html>
