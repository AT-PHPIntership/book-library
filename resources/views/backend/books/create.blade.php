@extends('backend.layouts.main')
@section('title', __('Add book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Book
      <small>{{ __('Add book') }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('admin') }}</a></li>
      <li><a href="#">{{ __('book') }}</a></li>
      <li class="active">{{ __('create') }}</li>
    </ol>
  </section>
  @include('flash::message')
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
                <input name="name" type="text" class="form-control" id="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}">
                @if($errors->first('name'))
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="name">{{ __('Category') }}</label>
                <select name="category_id" id="category">
                @foreach($categories as $category)
                  @if($category->id == 1)
                    @continue;
                  @endif
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
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
                <input name="price" type="text" class="form-control" id="status" placeholder="{{ __('Enter status') }}" value="{{ old('price') }}">
                @if($errors->first('price'))
                  <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="donator">{{ __('Donator') }}</label>
                <input name="donator_id" type="text" class="form-control" id="donator" placeholder="{{ __('Enter donator') }}" value="{{ old('donate_by') }}" >
                @if($errors->first('donator'))
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
                <label for="description">Description</label></br>
                <textarea name="description" class="textarea" placeholder="{{ __('Description about this book') }}"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                @if($errors->first('description'))
                  <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
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
                <button type="reset" class="btn btn-warning">{{ __('Clear') }}</button>
              </div>
            </form>
          </div>
          <div class="box body-pad">
        </div>
      </div>
      <!-- /.box -->
        
      </div>
      <!-- /.col-->
    </div>
    <!-- ./row -->
  </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
