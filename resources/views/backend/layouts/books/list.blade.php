@extends('backend.layouts.main')
@section('title', __('List book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!-- add form search and select for book -->
              <!-- start -->
              <form action="{{ url('admin/books/search') }}" method="GET" id="frm-search">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <span class="h3 text-uppercase">List of book</span>
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
              <table class="table table-hover" id="table-book">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Average review score</th>
                    <th>Total borrow</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($books as $key=>$book)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->author }}</td>
                    <td><span class="label label-success">{{ $book->avg_rating }}</span></td>
                    <td>{{ $book->total_rating }}</td>
                    <td align="center">
                    <a href="#"
                    class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                    <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <table class="table table-hover" id="table-book-ajax" style="display:none">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Average review score</th>
                    <th>Total borrow</th>
                  </tr>
                </thead>
                <tbody id='data'>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <div class="box-footer clearfix">
      <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">&laquo;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#frm-search').submit(function(e) {
      e.preventDefault();
      $('#table-book').hide();
      $('#table-book-ajax').show();
      data = $(this).serialize();
      $.get('/admin/books/search', data, function(search) {
        $('#data').empty();
        if (search.length === 0) {
            $('#data').append('<tr style="text-align:center"><td colspan="6"> <p class="h2">Sorry, Not Find Book</p> </td></tr>');
        }
        $.each(search, function(key, val) {
          $('#data').append(
          '<tr>'
            +'<td>'+ val.name + '</td>'
            +'<td>'+ val.author + '</td>'
            +'<td><span class="label label-success">' + val.avg_rating + '</span></td>'
            +'<td>'+ val.total_rating + '</td>'
            +'<td align="center">'
              +'<a href="#" class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>'
              +'<button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>'
            +'</td>'
          +'</tr>'
          );
        });
      });
    });
  </script>
@endsection
