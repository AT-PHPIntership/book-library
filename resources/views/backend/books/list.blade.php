@extends('backend.layouts.main')
@section('title',__('books.title_book'))
@section('content')
<!-- Modal -->
<div id="confirmDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <h3>{{ __('book.confirm.title') }}</h3>
        <p >{{ __('book.confirm.delete') }}
            <strong class="data-content"></strong>? 
        </p>
      </div>
      <div class="modal-footer">
        <button id="ok" type="button" class="btn btn-danger ok" data-dismiss="modal">{{ __('confirm.ok') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('confirm.close') }}</button>
      </div>
    </div>
    <!-- end content-->

  </div>
</div>
<!-- end modal-->

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>
              {{ __('books.list_book') }}
          </h1>
          <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('book.admin')  }}</a></li>
              <li class="active">{{ __('book.book') }}</li>
          </ol>
      </section>

      <section class="content">
         <div class="row">
             <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <!-- add form search and select for book -->
                        <!-- start -->
                        <form action="{{ route('books.index') }}" method="GET" id="frm-search">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <a class="btn btn-success" href="{{ route('books.create') }}">{{ __('books.add_book') }}</a>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" id="search-book" name="search" placeholder="{{ __('general.enter_name')}}" value="{{ Request::get('search')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <select class="form-control" id="choose-search" name="choose">
                                        @foreach (__('general.search') as $key => $value)
                                            <option value="{{ $key }}" {{ $key == Request::get('choose') ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="submit" class="btn btn-info form-control" id="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                       <!-- end -->
                    </div>
                </div>
            </div>
        </div>

        <!-- show message response -->
        @include('flash::message')

        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="table-book">
                       @if (count($books) > 0)
                      <thead>
                          <tr>
                              <th>@sortablelink('id', __('books.numbers_order'))</th>
                              <th>@sortablelink('name', __('books.name'))</th>
                              <th>@sortablelink('author', __('books.author'))</th>
                              <th>@sortablelink('avg_rating', __('books.average_review_score'))</th>
                              <th>@sortablelink('borrowings_count', __('books.total_borrow'))</th>
                              <th class="text-center text-info">{{ __('general.options') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->avg_rating }}</td>
                                <td>{{ $book->borrowings_count }}</td>
                                <td align="center">
                                    <a href="{{ route('books.edit', ['book' => $book, 'page' => $_SERVER['REQUEST_URI']]) }}"
                                       class= "btn btn-edit-{{ $book->id }} btn-primary btn-lg fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                                    <i class="btn btn-danger btn-lg fa fa-trash-o" id="{{ $book->id }}" data-toggle="modal" data-target="#confirmDelete" data-name="{{ $book->name }}"></i>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                      @else
                          <tr>
                              <td align="center" colspan="6">
                                  <p class="text-info h1">{{ __('book.not_found')}}</p>
                                  <a href="{{ route('books.index')}}" class="btn btn-default text-info">{{ __('general.comeback')}}</a>
                              </td>
                          </tr>
                      @endif
                  </table>
                  <div class="text-center">
                       {{ $books->appends(\Request::except('page'))->appends(['search' => Request::get('search'), 'choose' => Request::get('choose')])->render()}}
                  </div>
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
