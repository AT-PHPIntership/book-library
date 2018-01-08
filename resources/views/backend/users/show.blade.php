@extends('backend.layouts.main')
@section('title', __('user.profile_user'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ __('user.profile_user') }}</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> {{ __('user.admin') }}</a></li>
      <li><a href="{{ url('/admin/users') }}">{{ __('user.users') }}</a></li>
      <li class="active">{{ __('user.profile_user') }}</li>
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
            <h3 class="profile-username text-center">{{ $user->name }}</h3><center><a href=""><small>({{ __('user.edit_profile') }})</small></a></center>
            <p class="text-muted text-center">
              @if ($user->role == 1) {{ __('user.admin') }}
              @else {{ __('user.member') }}
              @endif
            </p>
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>{{ __('user.borrowed') }}</b> <a class="pull-right" href="#">{{ $user->total_borrowed }}</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('user.donated') }}</b> <a class="pull-right" href="#">{{ $user->total_donated }}</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('user.borrowing') }}</b> 
                <a class="pull-right" href="#">
                  @if (isset($borrowing->name)) {{ $borrowing->name }}
                  @else {{ __('user.none') }}
                  @endif
                </a>
              </li>
              <li class="list-group-item">
                <b>{{ __('user.ratings') }}</b> <a class="pull-right" href="#">{{ $user->total_ratings }}</a>
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
            <h3 class="box-title"><strong>{{ __('user.about') }}</strong></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}
            <hr>
            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp<em>{{ date('d-m-Y', strtotime($user->created_at)) }}</em>
            <hr>
            <i class="fa fa-thumbs-o-up"></i> {{ __('user.list_book_liked') }}
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('user.favorite_genres') }}
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('user.favorite_authors') }}
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