@extends('backend.layouts.main')
@section('title',__('post.post_title'))
@section('content')
<!-- Modal confirm delete post-->
<div id="confirmDeletePost" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h3>{{ __('post.confirm.title') }}</h3>
                <p>{{ __('post.confirm.delete_post') }} ?</p>
            </div>
            <div class="modal-footer">
                <button id="confirm-delete-post" type="button" class="btn btn-danger" data-dismiss="modal">{{ __('confirm.ok') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('confirm.close') }}</button>
            </div>
        </div>
        <!-- end content-->
    </div>
</div>
<!-- end modal-->

<!-- Modal confirm delete comment -->
<div id="confirmDeleteComment" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <div class="modal-body text-center">
                <h3>{{ __('post.confirm.title') }}</h3>
                <p>{{ __('post.confirm.delete_comment') }} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-ok" class="btn btn-danger" data-dismiss="modal">{{ __('confirm.ok') }}</button>
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
        {{ __('post.detail_post')}}
      </h1>
    </section>
        <section class="content">
          <div class="row">
            <div class="col-md-2">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                      <img class="img-thumbnail" src="{{ $post->image_url }}">
                </div>
                <!-- End Profile Image -->
              </div>
            </div>
            <div class="col-md-10">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="{{ $post->type_lable[0]}}" data-toggle="tab" value="">{{ strtoupper($post->type_lable[1]) }}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div>
                                <div class="h2">
                                    {{$post->users->name}}
                                </div>
                                <ol class="breadcrumb">
                                    @if ($post->type == App\Model\Post::REVIEW_TYPE)
                                        <li><b>{{ __('post.score') }} :</b>
                                            <i>{{ $post->rating or '0' }}</i>
                                        </li>
                                    @endif
                                    <li><b>{{ __('post.date') }} :</b><i> {{ $post->created_at }}</i></li>
                                    <li>
                                      <form method="POST" action="{{ route('posts.destroy', $post->id) }}" id="form-delete-post" class="inline">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-danger btn-flat fa fa-trash-o" data-toggle="modal" data-target="#confirmDeletePost"></button>
                                      </form>
                                    </li>
                                </ol>
                            </div>
                            <p>
                                {{ $post->content }}
                            </p>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="content">
            <div id="message">
            </div>
              @if ($comments->count() > 0)
              <div class="row">
                  <div class="col-md-12">
                      <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab">Comments</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Comment -->
                                    <div class="post">
                                      {!! showComment($comments) !!}
                                    </div>
                                </div>
                                    <!-- /.Comment -->
                            </div>
                      </div>
                </div>
              </div>
              @endif
        </section>
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/delete_comment.js') }}">
    </script>
    <script>
      newComment.deleteComment();
    </script>
@endsection
