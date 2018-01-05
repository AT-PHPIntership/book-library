@extends('backend.layouts.main')
@section('title', __('show.profile_user'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ __('show.profile_user') }}</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-show"></i> {{ __('show.admin') }}</a></li>
      <li><a href="#">{{ __('show.users') }}</a></li>
      <li class="active">{{ __('show.profile_user') }}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="" alt="User profile picture">
            <h3 class="profile-username text-center"></h3> <center><a href=""><small>({{ __('show.edit_profile') }})</small></a></center>
            <p class="text-muted text-center"></p>
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>{{ __('show.borrowed') }}</b> <a class="pull-right" href="#"></a>
              </li>
              <li class="list-group-item">
                <b>{{ __('show.donated') }}</b> <a class="pull-right" href="#"></a>
              </li>
              <li class="list-group-item">
                <b>{{ __('show.borrowing') }}</b> <a class="pull-right" href="#"></a>
              </li>
              <li class="list-group-item">
                <b>{{ __('show.ratings') }}</b> <a class="pull-right" href="#"></a>
              </li>
              <li class="list-group-item">
                <b>{{ __('show.reviews') }}</b> <a class="pull-right" href="#"></a>
              </li>
            </ul>
            <a href="#" class="btn btn-primary btn-block"><b>{{ __('show.follow') }}</b></a>
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
            <h3 class="box-title"><strong>{{ __('show.about') }}</strong></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
            <hr>
            <i class="fa fa-mobile"></i>
            <hr>
            <i class="fa fa-birthday-cake"></i>
            <hr>
            {{ __('show.joined_date') }}: <em></em>
            <hr>
            <i class="fa fa-thumbs-o-up"></i> {{ __('show.list_book_liked') }}
            <p><small><i></i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('show.favorite_genres') }}
            <p><small><i></i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> {{ __('show.favorite_authors') }}
            <p><small><i></i></small></p>
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
