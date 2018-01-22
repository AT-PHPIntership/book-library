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
      <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i>{{ __('post.admin')  }}</a></li>
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
              @foreach ($posts as $post)
              <tr>
                <td>{{ $post->id }}</td>
                <td><a href="{{ route('posts.show', ['id' => $post->id])}}">{{ $post->name }}</td></a>
                <td>
                @switch($post->type)
                  @case(1)
                    Review
                    @break
                  @case(2)
                    Status
                    @break
                  @case(3)
                    Find book
                    @break
                @endswitch
                </td>
                <td>{!! \Illuminate\Support\Str::words($post->content, 5,'...')  !!}</td>
                <td>{{ $post->created_at }}</td>
                <td class='text-center' >{{ $post->comments_count }}</td>
              </tr>
              @endforeach
            </tbody>
            </table>
            <!-- .pagination -->
            <div class="text-center">
              <nav aria-label="...">
                <ul class="pagination">
                  {{ $posts->links() }}
                </ul>
              </nav>
            </div>
            <!-- /.pagination -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
