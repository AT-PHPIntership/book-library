@extends('backend.layouts.main')
@section('title',__('books.title_book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="container">
        <!-- /.row -->
        <div class="row">
          <div class="col-md-10">
            <div class="box">
              <div class="box-header">
                  <!-- add form search and select for book -->
                  <!-- start -->
                  <form action="{{ url('admin/books/search') }}" method="GET" id="frm-search">
                      <div class="form-row">
                          <div class="form-group col-md-3">
                              <span class="h3 text-uppercase">{{ __('books.list_book') }}</span>
                          </div>
                          <div class="form-group col-md-5">
                              <input type="text" class="form-control" id="search" name="search" value="{{ old('search') }}">
                          </div>
                          <div class="form-group col-md-2">
                              <select id="select_search" class="form-control" name="searchBy" value="{{ old('searchBy') }}">
                                  <option selected>All</option>
                                  <option>Author</option>
                                  <option>Name</option>
                              </select>
                          </div>
                          <div class="form-group col-md-2">
                              <button type="submit" class="btn btn-default" ><i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </form>
                 <!-- end -->
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover" id="data-table">
                  <tr>
                    <th>{{ __('books.numbers_order') }}</th>
                    <th>{{ __('books.name') }}</th>
                    <th>{{ __('books.author') }}</th>
                    <th>{{ __('books.average_review_score') }}</th>
                    <th>{{ __('books.total_borrow') }}</th>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="label label-success">Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    <td align="center">
                    <a href="#"
                    class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                    <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                    </td>
                  </tr>
                  <tr>
                    <td>219</td>
                    <td>Alexander Pierce</td>
                    <td>11-7-2014</td>
                    <td><span class="label label-warning">Pending</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    <td align="center">
                    <a href="#"
                    class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                    <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                    </td>
                  </tr>
                  <tr>
                    <td>657</td>
                    <td>Bob Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="label label-primary">Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    <td align="center">
                    <a href="#"
                    class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                    <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                    </td>
                  </tr>
                  <tr>
                    <td>175</td>
                    <td>Mike Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="label label-danger">Denied</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    <td align="center">
                    <a href="#"
                    class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                    <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
