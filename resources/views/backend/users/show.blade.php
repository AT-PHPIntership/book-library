@extends('backend.layouts.main')
@section('title', __('user.user_profile'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ __('user.profile_user') }}</h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home.index') }}"><i class="fa fa-dashboard"></i>{{ __('user.admin')  }}</a></li>
      <li><a href="{{ route('users.index') }}">{{ __('user.users') }}</a></li>
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
            @if(isset($user->avatar_url))
            <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}">
            @else
            <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}" style="display:none" >
            @endif
            <h3 class="profile-username text-center">{{ $user->name }}</h3><center></center>
            <p class="text-muted text-center">
              {{ $user->roleName }}
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
                @if (isset($bookBorrowing->name)) <a class="pull-right" href="#">{{ $bookBorrowing->name}} </a>
                @else <span class="pull-right">{{ __('user.none') }}</span>
                @endif
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
              <h3 class="box-title"><strong>{{ __('user.about') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-user-circle-o margin-r-5"></i>{{ __('fullname') }}:</strong>
              <p class="text-muted margin-r-5 username">{{ $user->name }}</p>
              <hr>
              <strong><i class="fa fa-calendar-plus-o margin-r-5"></i>{{ __('join_dated') }}:</strong>
              <p class="text-muted margin-r-5 join_date">{{ date('d-m-Y', strtotime($user->created_at)) }}</p>
              <hr>
              <strong><i class="fa fa-envelope-o margin-r-5"></i>{{ __('email') }}</strong>
              <p class="text-muted margin-r-5 email">{{ $user->email }}</p>
              <hr>
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
