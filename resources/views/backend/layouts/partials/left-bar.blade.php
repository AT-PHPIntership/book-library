<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ Auth::user()->avatar_url }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><a href="{{route('users.show', Auth::user()->employee_code)}}">{{Auth::user()->name}}</a></p>
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
      <li class="{{ isActiveRoute('home.index') }}">
        <a href="{{ route('home.index') }}">
          <i class="fa fa-home" aria-hidden="true"></i> <span>{{ __('dashboard.home_page') }}</span>
        </a>
      </li>
      <li class="{{ areActiveRoute(['users.index', 'users.edit', 'users.show']) }}">
        <a href="{{ route('users.index') }}">
          <i class="fa fa-male" aria-hidden="true"></i>
          <span>{{ __('dashboard.users') }}</span>
          <span class="pull-right-container">
              <small class="label pull-right bg-blue">{{ getCount(App\Model\User::class) }}</small>
          </span>
        </a>
      </li>
      <li class="{{ areActiveRoute(['books.index', 'books.edit', 'books.show']) }}">
        <a href="{{route('books.index')}}">
          <i class="fa fa-book" aria-hidden="true"></i>
          <span>{{ __('dashboard.books') }}</span>
          <span class="pull-right-container">
              <small class="label pull-right bg-green">{{ getCount(App\Model\Book::class) }}</small>
          </span>
        </a>
      </li>
      <li class="{{ areActiveRoute(['categories.index', 'categories.edit']) }}">
        <a href="#">
          <i class="fa fa-list" aria-hidden="true"></i>
          <span>{{ __('dashboard.categories') }}</span>
          <span class="pull-right-container">
              <small class="label pull-right bg-orange">{{ getCount(App\Model\Category::class) }}</small>
          </span>
        </a>
      </li>
      <li class="{{ areActiveRoute(['posts.index', 'posts.edit', 'posts.show']) }}">
        <a href="#">
          <i class="fa fa-id-card-o" aria-hidden="true"></i>
          <span>{{ __('dashboard.posts') }}</span>
          <span class="pull-right-container">
              <small class="label pull-right bg-purple">{{ getCount(App\Model\Post::class) }}</small>
          </span>
        </a>
      </li>
    </ul>
  </section>
</aside>
