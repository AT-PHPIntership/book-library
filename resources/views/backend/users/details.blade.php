@extends('backend.layouts.main')
@section('title', __('Add book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>User Profile</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="#">Users</a></li>
      <li class="active">User profile</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" alt="User profile picture">

            <h3 class="profile-username text-center">Alexander Pierce</h3> <center><a href=""><small>(edit profile)</small></a></center>

            <p class="text-muted text-center">Member</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Borrowed</b> <a class="pull-right" href="#">11</a>
              </li>
              <li class="list-group-item">
                <b>Donated</b> <a class="pull-right" href="#">6</a>
              </li>
              <li class="list-group-item">
                <b>Borrowing</b> <a class="pull-right" href="#">Basic HTML</a>
              </li>
              <li class="list-group-item">
                <b>Ratings</b> <a class="pull-right" href="#">0</a>
              </li>
              <li class="list-group-item">
                <b>Reviews</b> <a class="pull-right" href="#">0</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
            <h3 class="box-title"><strong>About</strong></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> alexander.pierce@asiantech.vn
            <hr>
            <i class="fa fa-mobile"></i>  0905951611
            <hr>
            <i class="fa fa-birthday-cake"></i> November 16, 1995
            <hr>
            Joined date: <em>Nov 20, 2017</em>
            <hr>
            <i class="fa fa-thumbs-o-up"></i> List Book Liked
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> Favorite Genres
            <p><small><i>Not selected yet.</i></small></p>
            <hr>
            <i class="fa fa-heart-o"></i> Favorite Authors
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