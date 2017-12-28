<header class="main-header"> 
  <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('bower_components/admin-lte/dist/img/shank.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">An Nguyen Q.</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('bower_components/admin-lte/dist/img/shank.jpg') }}" class="img-circle" alt="User Image">

                <p>
                  An Nguyen Q. - Web Developer
                  <small>Birthday: 11-09-1995</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                {{--  <div class="pull-right">
                   <form action="{{ route('logout') }}" method="POST">
                    {{csrf_field()}}
                    <button type="submit" name="logout">
                      {{__('Log out')}}
                    </button>
                  </form>
                </div>  --}}
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>