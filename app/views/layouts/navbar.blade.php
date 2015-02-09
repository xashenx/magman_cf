<nav class="navbar-default navbar-side" role="navigation">

  <div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
      <li class="red-line"></li>
      <li>
        <a href="{{ URL::asset('home') }}">
          <span class="glyphicon glyphicon-dashboard btn-lg" aria-hidden="true"></span>
          Dashboard
        </a>
      </li>
      @if(Auth::user()->level_id == 1)
        <li>
          <a href="{{ URL::asset('newShipment') }}">
            <span class="glyphicon glyphicon-plus btn-lg" aria-hidden="true"></span>
            Nuovi Arrivi
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('boxes') }}">
            <span class="glyphicon glyphicon-user btn-lg" aria-hidden="true"></span>
            Caselle
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('comics') }}">
            <span class="glyphicon glyphicon-book btn-lg" aria-hidden="true"></span>
            Fumetti
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('series') }}">
            <span class="glyphicon glyphicon-th-list btn-lg" aria-hidden="true"></span>
            Serie
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('#') }}">
            <span class="glyphicon glyphicon-cog btn-lg" aria-hidden="true"></span>
            Impostazioni
          </a>
        </li>
      @endif

      @if(Auth::user()->level_id == 2)
        <li>
          <a href="{{ URL::asset('box') }}">
            <span class="glyphicon glyphicon-th-list btn-lg" aria-hidden="true"></span>
            Casella
          </a>
        </li>
        <li>
          <a href="{{ URL::asset('mail') }}">
            <span class="glyphicon glyphicon-comment btn-lg" aria-hidden="true"></span>
            Contatti
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