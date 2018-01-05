<header class="main-header">
  <a href="index2.html" class="logo">
    <span class="logo-mini"><b>A</b>dm</span>
    <span class="logo-lg"><b>{{__('Admin ')}}</b>{{__('Management')}}</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ Auth::user()->avatar_url }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ Auth::user()->avatar_url }}" class="img-circle" alt="User Image">
              <p>
                {{ Auth::user()->name }} - {{ Auth::user()->team }}
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">{{__('Profile')}}</a>
              </div>
              <div class="pull-right">
                <form action="{{ route('logout') }}" method="POST">
                  {{csrf_field()}}
                  <button type="submit" name="logout">
                    {{__('login.logout')}}
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
