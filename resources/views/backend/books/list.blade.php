@extends('backend.layouts.main')
@section('title',__('books.title_book'))
@section('content')
<!-- Modal -->
@include ('backend.books.partials.import-modal')
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
    <!-- show message response -->
    @include('flash::message')
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>
              {{ __('books.list_book') }}
          </h1>
          <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('book.admin')  }}</a></li>
              <li class="active">{{ __('book.books') }}</li>
          </ol>
      </section>

      <section class="content">
         <div class="row">
             <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <!-- add form search and select for book -->
                        <!-- start -->
                            <div class="form-row">
                                <div class="col-md-3">
                                    <ul id="accordion" class="accordion">
                                      <li>
                                        <div class="link"><i class="fa fa-book"></i>{{ __('book.dropmenu') }}<i class="fa fa-chevron-down"></i></div>
                                        <ul class="submenu">
                                          <li>
                                            <a class="btn btn-success" href="{{ route('books.create') }}">{{ __('books.add_book') }}</a>
                                          </li>
                                          <li>
<<<<<<< HEAD
                                            <form files="true" id="import-form" action="{{ route('books.import') }}" method="post" enctype="multipart/form-data">
                                              {{csrf_field()}}
=======
                                            <form id="import-form" action="" method="post" enctype="multipart/form-data">
>>>>>>> master
                                              <input type="file" name="import-data" class="form-control" id="import-book">
                                            </form>
                                          </li>
                                        </ul>
                                      </li>
                                    </ul>
                                    @if($errors->first('import-data'))
                                      <span class="text-danger">{{ $errors->first('import-data') }}</span>
                                    @endif
                                </div>
                              <form action="{{ route('books.index') }}" method="GET" id="frm-search">
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
                              </form>
                            </div>
                       <!-- end -->
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover" id="table-book">
                       @if (count($books) > 0)
                      <thead>
                          <tr>
                              <th>@sortablelink('id', __('books.numbers_order'))</th>
                              <th>@sortablelink('name', __('books.name'))</th>
                              <th>@sortablelink('author', __('books.author'))</th>
                              <th class="text-center">@sortablelink('avg_rating', __('books.average_review_score'))</th>
                              <th class="text-center">@sortablelink('borrowings_count', __('books.total_borrow'))</th>
                              <th class="text-center text-info">{{ __('general.options') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->author }}</td>
                                <td class="text-center">{{ $book->avg_rating }}</td>
                                <td class="text-center">{{ $book->borrowings_count }}</td>
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
@section('script')
  <script src="{{ asset('js/excel.js')  }}"></script>
@endsection
