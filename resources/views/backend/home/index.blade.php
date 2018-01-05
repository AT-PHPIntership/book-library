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
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="user">{{ $user->name }}</div>
                <div class="user">{{ $user->email }}</div>
                <div class="user">{{ $user->team }}</div>
                <div class="">
                    <img style="width: 60px;height: 60px;object-fit: cover;border: 6px solid #fff;border-radius: 50%;" src="{{ $user->avatar_url }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ./wrapper -->

@endsection