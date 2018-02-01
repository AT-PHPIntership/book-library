@extends('backend.layouts.main')

@section('title', __('home.title'))

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('home.title') }}
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{getCount(App\Model\User::class)}}</h3>

              <p>{{ __('home.users') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">{{__('home.more_info')}}<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{getCount(App\Model\Book::class)}}</h3>

              <p>{{__('home.books')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-book"></i>
            </div>
            <a href="{{ route('books.index') }}" class="small-box-footer">{{__('home.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{getCount(App\Model\Category::class)}}</h3>

              <p>{{__('home.categories')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-list"></i>
            </div>
            <a href="" class="small-box-footer">{{__('home.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{getCount(App\Model\Post::class)}}</h3>

              <p>{{__('home.posts')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-bookmarks"></i>
            </div>
            <a href="" class="small-box-footer">{{__('home.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-violet" id="donator">
            <div class="inner">
              <h3>{{__('home.top_5')}}</h3>

              <p>{{__('home.donator')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-contacts"></i>
            </div>
            <a href="{{ route('users.index', ['filter' => 'donated', 'limit' => '5']) }}" class="small-box-footer top-donator">{{__('home.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red" id="borrowed">
            <div class="inner">
              <h3>{{__('home.top_10')}}</h3>

              <p>{{__('home.books_borrowed')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-heart"></i>
            </div>
            <a href="{{ route('books.index', ['filter' => 'borrowed', 'limit' => '10']) }}" class="small-box-footer">{{__('home.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ./wrapper -->
@endsection
