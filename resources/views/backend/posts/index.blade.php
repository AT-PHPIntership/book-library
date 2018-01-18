@extends('backend.layouts.main')
@section('title',__('post.post_title'))
@section('content')

<!-- Content Wrapper -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('post.list_post')  }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('post.admin')  }}</a></li>
      <li class="active">{{ __('post.post_title') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
         <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>{{ __('post.id') }}</th>
                <th>{{ __('post.user_name') }}</th>
                <th>{{ __('post.type_post') }}</th>
                <th>{{ __('post.short_content') }}</th>
                <th>{{ __('post.post_date') }}</th>
                <th>{{ __('post.total_comment') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Orion Daugherty</td>
                <td>Review</td>
                <td>Incidunt voluptatem officiis esse quis in...</td>
                <td>1 - 1 - 2018</td>
                <td>5</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Eriberto Stiedemann III</td>
                <td>Find book</td>
                <td>Incidunt voluptatem officiis esse quis in...</td>
                <td>1 - 1 - 2018</td>
                <td>10</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Prof. Pasquale Hintz</td>
                <td>Status</td>
                <td>Incidunt voluptatem officiis esse quis in...</td>
                <td>1 - 1 - 2018</td>
                <td>3</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Orion Daugherty</td>
                <td>Review</td>
                <td>Incidunt voluptatem officiis esse quis in...</td>
                <td>1 - 1 - 2018</td>
                <td>10</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Orion Daugherty</td>
                <td>Review</td>
                <td>Incidunt voluptatem officiis esse quis in...</td>
                <td>1 - 1 - 2018</td>
                <td>10</td>
              </tr>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
