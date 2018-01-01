@extends('backend.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Text Editors
      <small>Advanced form element</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>admin</a></li>
      <li><a href="#">book</a></li>
      <li class="active">create</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="box box-info">
          <!-- /.box-header -->
          <div class="box-body pad">
            <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}">
                @if($errors->first('name'))
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <select name="category_id" id="category">
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
              </select>
              <div class="form-group">
                <label for="author">Author</label>
                <input name="author" type="text" class="form-control" id="author" placeholder="Enter author" value="{{ old('author') }}">
                @if($errors->first('author'))
                  <span class="text-danger">{{ $errors->first('author') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input name="price" type="text" class="form-control" id="status" placeholder="Enter status" value="{{ old('price') }}">
                @if($errors->first('price'))
                  <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="donate_by">Donate By</label>
                <input name="donate_by" type="text" class="form-control" id="donate_by" placeholder="Enter donater" value="{{ old('donate_by') }}" >
                @if($errors->first('donate_by'))
                  <span class="text-danger">{{ $errors->first('donate_by') }}</span>
                @endif
                @if(session('no_exist'))
                  <span class="text-danger">{{session('no_exist')}}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="year">Year</label>
                <input name="year" type="text" class="form-control" id="year" placeholder="Enter year" value="{{ old('year') }}">
                @if($errors->first('year'))
                  <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="description">Description</label></br>
                <textarea id="editor1" name="description" rows="10" cols="80"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Book Image</label>
                <input name="image" type="file" id="exampleInputFile">
                <p class="help-block">Only upload image with maximum 10mb</p>
                @if($errors->first('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>

              <div class="box-footer">
                <button id="btn-add-book" type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-warning">Clear</button>
              </div>
            </form>
          </div>
          <div class="box body-pad">
          <form action="" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-footer">
              <label for="exampleInputFile">Select excel file to import</label></br>
              <input class="btn btn-success" name="excel" type="file" id="btn-import-excel">
              <button id="btn-submit-file" type="submit" class="btn btn-primary">Import</button>
            </div>
          </form>
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
