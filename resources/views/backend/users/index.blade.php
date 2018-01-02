@extends('backend.layouts.main')

@section('title','User')

@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      List Users
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Users</a></li>
      <li class="active">List users</li>
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
                <th>No.</th>
                <th>Employee code</th>
                <th>Name</th>
                <th>Number of books donated</th>
                <th>Number of books borrowed</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>1</td>
                <td>AT2012</td>
                <td>Employee 1</td>
                <td>4</td>
                <td>9</td>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
@endsection
