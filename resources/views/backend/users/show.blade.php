@extends('backend.layouts.main')
@section('title', __('Add book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ __('User Profile') }}</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> {{ __('Admin') }}</a></li>
      <li><a href="{{ url('/admin/users') }}">{{ __('Users') }}</a></li>
      <li class="active">{{ __('User profile') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $user->name }}</h3><center><a href=""><small>({{ __('Edit profile') }})</small></a></center>
            <p class="text-muted text-center">
              @if ($user->role == 1) {{ __('admin') }}
              @else {{ __('member') }}
              @endif
            </p>
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>{{ __('Borrowed') }}</b> <a class="pull-right" href="#">{{ $user->total_borrowed }}</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('Donated') }}</b> <a class="pull-right" href="#">{{ $user->total_donated }}</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('Borrowing') }}</b> 
                <a class="pull-right" href="#">
                  @if (isset($borrowing->name)) {{ $borrowing->name }}
                  @else {{ __('None') }}
                  @endif
                </a>
              </li>
              <li class="list-group-item">
                <b>{{ __('Ratings') }}</b> <a class="pull-right" href="#">{{ $user->total_ratings }}</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>{{ __('Follow') }}</b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>{{ __('About') }}</strong></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}
            <hr>
            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp<em>{{ date('d-m-Y', strtotime($user->created_at)) }}</em>
            <hr>
            <i class="fa fa-thumbs-o-up"></i> {{ __('List Book Liked') }}
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('Favorite Genres') }}
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('Favorite Authors') }}
            <p><small><i>Not selected yet.</i></small></p>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
  
</div>
<!-- /.content-wrapper -->
@endsection