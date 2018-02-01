@extends('backend.layouts.main')
@section('title',__('category.title'))
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div id="category-delete-message"></div>
  <section class="content-header">
    <h1>{{ __('category.title') }}</h1>
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
          <div id="load-paginate" class="box-body table-responsive no-padding">
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

            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><center><b>{{ __('category.rename') }}</b></center></h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="id">{{ __('category.id') }}:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="idCategory" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="name">{{ __('category.name') }}:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="nameCategory" autofocus>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-10 col-sm-push-2">
                          <p class="errors text-warning"></p>
                        </div>
                      </div>
                    </form>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-UpdateNameCategory">
                        <span id="footer_action_button" class='glyphicon glyphicon-check'>{{ __('category.update') }}</span>
                      </button>
                      <button type="button" class="btn btn-warning btn-close-update-category" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'>{{ __('category.close') }}</span> 
                      </button>
                    </div>
                  </div>
                  <!-- /.box -->
                </div>
              </div>
            </div>

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
                <tr class="category{{ $category->id }}">
                  <td class="text-center">{{ $category->id }}</td>
                  <td id="nameCategory{{ $category->id }}" class="margin-l-5">{{ $category->name }}</td>
                  <td class="text-center">{{ $category->books_count }}</td>
                  <td class="text-center">
                    <button class="btn-show-edit-modal btn btn-info" id="edit-modal{{ $category->id }}" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-toggle="modal" data-target="#myModal">
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
                {{ $categories->links() }}
              </nav>
            </div>
            <!-- /.pagination -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="{{ asset('app/js/category.js') }}">
            </script>
            <script>
              newCategory.loadPage("{{ isset($paginateAttr['uri']) ? $paginateAttr['uri'] : '' }}", "{{ Request::get('page') }}", "{{ __('category.delete_success') }}");
              newCategory.editNameCategory();
              newCategory.updateNameCategory();
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
