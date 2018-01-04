<header class="main-header">
  <a href="index2.html" class="logo">
    <span class="logo-mini"><b>A</b>dm</span>
    <span class="logo-lg"><b>{{__('Admin ')}}</b>{{__('Management')}}</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
            <span class="hidden-xs">Alexander Pierce</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
              <p>
                Alexander Pierce - {{__('Web Developer')}}
                <small>{{__('Member since Jun. 2017')}}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">{{__('Profile')}}</a>
              </div>
              <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat">{{__('Log out')}}</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
