<nav class="navbar-default navbar-side" role="navigation">

  <div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
      <li class="red-line"></li>
      <li>
        <a href="{{ URL::asset('home') }}">
          <i class="fa fa-dashboard fa-3x sidebar-icon"></i>
          Dashboard
        </a>
      </li>
      @if(Auth::user()->level_id == 1)
        <li>
          <a href="{{ URL::asset('newShipment') }}">
            <i class="fa fa-plus-square fa-3x sidebar-icon"></i>
            Nuovi Arrivi
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('boxes') }}">
            <i class="fa fa-user fa-3x sidebar-icon"></i>
            Caselle
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('comics') }}">
            <i class="fa fa-book fa-3x sidebar-icon"></i>
            Fumetti
          </a>
        </li>
      @endif

      @if(Auth::user()->level_id == 2)
        <li>
          <a href="{{ URL::asset('box') }}">
            <i class="fa fa-user fa-3x sidebar-icon"></i>
            Casella
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('mail') }}">
            <i class="fa fa-user fa-3x sidebar-icon"></i>
            Contatti
          </a>
        </li>
      @endif

      @if(Auth::user()->level_id == 1)
        <li>
          <a href="{{ URL::asset('series') }}">
            <i class="fa fa-th-large fa-3x sidebar-icon"></i>
            Serie
          </a>
        </li>
      @endif

      @if(Auth::user()->level_id == 100)
        <li>
          <a href="#">
            <i class="fa fa-gear fa-3x sidebar-icon"></i>
            Gestione parametri fissi
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level">
            <li>
              <a href="#">Second Level Link</a>
            </li>
            <li>
              <a href="#">Second Level Link</a>
            </li>
            <li>
              <a href="#">
                Second Level Link
                <span class="fa arrow"></span>
              </a>
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