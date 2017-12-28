<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('bower_components/admin-lte/dist/img/shank.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>An Nguyen Q.</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
    <!--   <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">{{ __('Tools Option') }}</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>{{ __('Home Page') }}</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>{{ __('Booking Films') }}</span>
          </a>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-laptop"></i> <span>{{__('Cinemas') }}</span>
            <span class="pull-right-container">
              {{--  <small class="label pull-right bg-green">{{ getCount('cinemas') }}</small>  --}}
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-map-o"></i>
            <span>{{ __('Cities') }}</span>
            <span class="pull-right-container">
              {{--  <span class="label label-primary pull-right">{{ getCount('cities') }}</span>  --}}
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>{{ __('Detail Booking') }}</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-film"></i>
            <span>{{ __('Films') }}</span>
            <span class="pull-right-container">
              {{--  <span class="label label-primary pull-right">{{ getCount('films') }}</span>  --}}
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>{{ __('Seats') }}</span>
          </a>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>{{ __('Schedules') }}</span>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class=" fa fa-user"></i> <span>{{ __('Users') }}</span>
            <span class="pull-right-container">
            {{--  <small class="label pull-right bg-green">{{  getCount('users') }}</small>  --}}
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>