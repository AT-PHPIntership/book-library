@extends('backend.layouts.main')
@section('title', __('Add book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('Book') }}
      <small>{{ __('create book') }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('admin') }}</a></li>
      <li><a href="#">{{ __('book') }}</a></li>
      <li class="active">{{ __('create') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="box box-info">
          <!-- /.box-header -->
          <div class="box-body pad">
            <form action="" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}">
                @if($errors->first('name'))
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="category_id">{{ __('Category') }}</label></br>
                <select name="category_id" id="category">
                </select>
              </div>
              <div class="form-group">
                <label for="author">{{ __('Author') }}</label>
                <input name="author" type="text" class="form-control" id="author" placeholder="{{ __('Enter author') }}" value="{{ old('author') }}">
                @if($errors->first('author'))
                  <span class="text-danger">{{ $errors->first('author') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="price">{{ __('Price') }}</label>
                <input name="price" type="text" class="form-control" id="price" placeholder="{{ __('Enter status') }}" value="{{ old('price') }}">
                @if($errors->first('price'))
                  <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="donator">{{ __('Donator') }}</label>
                <input name="donator" type="text" class="form-control" id="donator" placeholder="{{ __('Enter donator') }}" value="{{ old('donator') }}" >
                @if($errors->first('donate_by'))
                  <span class="text-danger">{{ $errors->first('donator') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="year">{{ __('Year') }}</label>
                <input name="year" type="text" class="form-control" id="year" placeholder="{{ __('Enter year') }}" value="{{ old('year') }}">
                @if($errors->first('year'))
                  <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="description">{{__('Description') }}</label></br>
                <textarea name="description" id="description" class="textarea" placeholder="{{ __('Description about this book') }}"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">{{ __('Book Image') }}</label>
                <input name="image" type="file" id="exampleInputFile">
                <p class="help-block">{{ __('Only upload image with maximum 10mb') }}</p>
                @if($errors->first('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>

              <div class="box-footer">
                <button id="btn-add-book" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>
                <button id="btn-back" type="reset" class="btn btn-warning">{{ __('Back') }}</button>
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
