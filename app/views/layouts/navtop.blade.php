<nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">

  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.html">
      <img src="{{ URL::asset('assets/img/logo.png') }}" class="img-responsive"/>
    </a>
  </div>

  <div class="welcome-div">
    Benvenuto
    <a href="{{ URL::asset('profile') }}" class="profile">{{Auth::user()->name}}</a>! &nbsp;
    <a href="{{ URL::asset('logout') }}" class="btn btn-danger square-btn-adjust">Logout</a>
  </div>

</nav>
<!-- /. NAV TOP  -->