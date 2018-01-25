@extends('backend.layouts.main')
@section('title',__('category.title'))
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>
              {{ __('category.title') }}
          </h1>
          <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('category.admin')  }}</a></li>
              <li class="active">{{ __('category.category') }}</li>
          </ol>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="table-book">
                      <thead>
                          <tr>
                              <th class="text-center">{{ __('category.id') }}</th>
                              <th>{{ __('category.name') }}</th>
                              <th class="text-center">{{ __('category.number_of_books') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <th class="text-center"></th>
                              <th class="margin-l-5"></th>
                              <th class="text-center"></th>
                          </tr>
                      </tbody>
                  </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
@endsection