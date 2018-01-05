<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i>{{ __('dashboard.online')  }}</a>
      </div>
    </div>
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_navigation') }}</li>
      <li>
        <a href="">
          <i class="fa fa-home" aria-hidden="true"></i> <span>{{ __('dashboard.home_page') }}</span>
        </a>
      </li>
      <li>
        <a href='{!! url('/admin/users'); !!}'>
          <i class="fa fa-male" aria-hidden="true"></i>
          <span>{{ __('dashboard.users') }}</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-book" aria-hidden="true"></i>
          <span>{{ __('dashboard.books') }}</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-list" aria-hidden="true"></i>
          <span>{{ __('dashboard.categories') }}</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
