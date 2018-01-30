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
                              <th class="text-center">{{ __('category.actions') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($categories as $category)
                          <tr class="category{{$category->id}}">
                              <td class="text-center">{{ $category->id }}</td>
                              <td id="nameCategory{{$category->id}}" class="margin-l-5">{{ $category->name }}</td>
                              <td class="text-center">{{ $category->books_count }}</td>
                              <td class="text-center">
                                <button type="button" class="edit-modal btn btn-info" id="edit-modal" data-id="{{$category->id}}"
  							data-name="{{$category->name}}">
                                    <span class="glyphicon glyphicon-edit"></span>
  						        </button>
                                <button type="button" class="btn btn-danger btn-lg fa fa-trash-o delete-category" id="{{ $category->id }}" data-toggle="modal" data-target="#confirmDelete" data-name="{{ $category->name }}"></button>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                   <!-- .pagination -->
                   <div class="text-center">
                    <nav aria-label="...">
                        <ul class="pagination">
                        {{ $categories->links() }}
                        </ul>
                    </nav>
                    </div>
                    <!-- /.pagination -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
    </section>

    <section id="pop-up">
    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><center><b>Rename Category</b></center></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="idCategory" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="nameCategory" autofocus>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success editCategory" data-dismiss="modal">
                        <span id="footer_action_button" class='glyphicon glyphicon-check'>Update</span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'>Close</span> 
                    </button>
                </div>
            </div>
        </div>
    </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
  <script src="{{ asset('app/js/category.js') }}"></script>
@endsection