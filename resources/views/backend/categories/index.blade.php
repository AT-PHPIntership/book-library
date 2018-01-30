@extends('backend.layouts.main')
@section('title',__('category.title'))
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- show message response -->
    <div id="category-delete-message"></div>
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
            <div id="unload-paginate" class="box-body table-responsive no-padding">
              <!-- Modal -->
              <div id="confirmDelete" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                      <h3>{{ __('category.confirm_delete_message') }}</h3>
                    </div>
                    <div class="modal-footer">
                      <button id="delete-category" type="button" class="btn btn-danger confirm" data-dismiss="modal">{{ __('confirm.ok') }}</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('confirm.close') }}</button>
                    </div>
                  </div>
                  <!-- end content-->
                </div>
              </div>
              <!-- end modal-->
              <table class="table table-hover" id="table-categories">
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
                  <tr>
                    <td class="text-center">{{ $category->id }}</td>
                    <td class="margin-l-5">{{ $category->name }}</td>
                    <td class="text-center">{{ $category->books_count }}</td>
                    <td class="text-center">
                      <button class="btn btn-info">
                        <span class="glyphicon glyphicon-edit"></span>
                      </button>
                      <button type="button" class="btn btn-danger btn-lg fa fa-trash-o delete-category" id="{{ $category->id }}" data-toggle="modal" data-target="#confirmDelete" data-name="{{ $category->name }}" "{{ ($category->id == App\Model\Category::DEFAULT_CATEGORY) ? " disabled " : '' }}"></button>
                      <i class="fa fa-spinner fa-spin delete-progress"></i>
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
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
              <script src="{{ asset('app/js/category.js') }}">
              </script>
              <script>
                category.unloadPage("{{ isset($url) ? $url : '' }}", "{{ Request::get('page') }}", "{{ __('category.delete_success') }}");
              </script>
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
