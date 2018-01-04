@extends('backend.layouts.main')
@section('title', __('dashboard.book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('dashboard.create_title') }}
      <small>{{ __('dashboard.create_book') }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('dashboard.admin') }}</a></li>
      <li><a href="#">{{ __('dashboard.book') }}</a></li>
      <li class="active">{{ __('dashboard.create') }}</li>
    </ol>
  </section>
    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="box box-info">
          <!-- /.box-header -->
          <div class="box-body pad">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="{{ __('dashboard.enter_name') }}" value="{{ old('name') }}">
                @if($errors->first('name'))
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="name">{{ __('dashboard.category') }}</label>
                <select name="category_id" id="category">
                </select>
              </div>
              <div class="form-group">
                <label for="author">{{ __('dashboard.author') }}</label>
                <input name="author" type="text" class="form-control" id="author" placeholder="{{ __('dashboard.enter_author') }}" value="{{ old('author') }}">
                @if($errors->first('author'))
                  <span class="text-danger">{{ $errors->first('author') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="price">{{ __('dashboard.price') }}</label>
                <input name="price" type="text" class="form-control" id="price" placeholder="{{ __('dashboard.enter_price') }}" value="{{ old('price') }}">
                @if($errors->first('price'))
                  <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="donator">{{ __('dashboard.donator') }}</label>
                <input name="donator_id" type="text" class="form-control" id="donator" placeholder="{{ __('dashboard.enter_donator') }}" value="{{ old('donate_by') }}" >
                @if($errors->first('donator_id'))
                  <span class="text-danger">{{ $errors->first('donator_id') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="year">{{ __('dashboard.year') }}</label>
                <input name="year" type="text" class="form-control" id="year" placeholder="{{ __('dashboard.enter_year') }}" value="{{ old('year') }}">
                @if($errors->first('year'))
                  <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="description">{{__('dashboard.description') }}</label></br>
                <textarea class="ckeditor" id="description" placeholder=""></textarea>
              <div class="form-group">
                <label for="exampleInputFile">{{ __('dashboard.image') }}</label>
                <input name="image" type="file" id="exampleInputFile">
                @if($errors->first('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>

              <div class="box-footer">
                <button id="btn-add-book" type="submit" class="btn btn-primary">{{ __('dashboard.submit') }}</button>
                <button type="reset" class="btn btn-danger">{{ __('dashboard.reset') }}</button>
                <button id="btn-back" type="reset" class="btn btn-warning">{{ __('dashboard.back') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- ./row -->
  </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
