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
        <p>{{ __('book.confirm.delete') }} ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('confirm.ok') }}</button>
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
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <!-- add form search and select for book -->
                        <!-- start -->
                        <form action="{{ route('books.index') }}" method="GET" id="frm-search">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <span class="h3 text-uppercase">{{ __('books.list_book') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" id="search-name" name="name" placeholder="{{ __('general.enter_name')}}" value="{{ Request::get('name')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" id="search-author" name="author" placeholder="{{ __('general.enter_author')}}" value="{{ Request::get('author')}}">
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="submit" class="btn btn-default" ><i class="fa fa-search"></i></button>
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
          <div class="col-md-10">
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
                              <th>{{ __('general.options') }}</th>
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
                                    <a href="{{ route('books.edit', $book->id) }}"
                                       class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                                    <i class="btn btn-danger btn-lg fa fa-trash-o"></i>
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
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
      </div>{{ $books->appends(\Request::except('page'))->appends(['name' => Request::get('name'), 'author' => Request::get('author')])->render()}}
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
