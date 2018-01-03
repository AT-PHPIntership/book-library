@extends('backend.layouts.main')

@section('title','User')

@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      List Users
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home Page</a></li>
      <li class="active">Users</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">List Users Table</h3>
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No</th>
                <th>Employee code</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>1</td>
                <td>AT-00001</td>
                <td>Employee 1</td>
                <td>a@asiantech.vn</td>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  <!-- /.content -->
</div>
@endsection
