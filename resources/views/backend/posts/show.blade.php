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
        <p >{{ __('post.confirm.delete_post') }} ?</p>
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
        <p >{{ __('post.confirm.delete_comment') }} ?</p>
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
    <section class="content-header">
      <h1>
        {{ __('post.detail_post')}}
      </h1>
    </section>
    <section class="content">
      <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
                @if ($post->image == '')
                  <img class="img-thumbnail" src="{{ asset('images/books/lrg.jpg')}}" alt="User profile picture">
                @else
                 <img class="img-thumbnail" src="{{ asset('images/books/'.$post->image)}}" alt="User profile picture">
                @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @switch($post->type)
                  @case(App\Model\Post::REVIEW_TYPE)
                    <li class="active"><a href="#activity" data-toggle="tab">{{ strtoupper(__('post.review')) }}</a></li>
                    @break
                  @case(App\Model\Post::STATUS_TYPE)
                    <li><a href="#timeline" data-toggle="tab">{{ strtoupper(__('post.status')) }}</a></li>
                    @break
                  @case(App\Model\Post::FIND_TYPE)
                    <li><a href="#settings" data-toggle="tab">{{ strtoupper(__('post.find_book')) }}</a></li>
                    @break
                @endswitch
            </ul>
            <!-- /.tab-content -->

            <div class="tab-content">
                <!-- /.display review -->

                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div>
                                <div class="h2">
                                    {{$post->name}}
                                </div>
                                <ol class="breadcrumb">
                                    @if ($post->type == 1)
                                        <li><b>{{ __('post.score') }} :</b>
                                            <i>
                                                {{$post->rating}}
                                            </i>
                                        </li>
                                    @endif
                                    <li><b>{{ __('post.date') }} :</b><i> {{ $post->created_at }}</i></li>
                                    <li><i class="fa fa-trash-o text-danger" data-toggle="modal" data-target="#confirmDeletePost"></i></li>
                                </ol>
                            </div>
                          <!-- /.user-block -->
                            <p>
                                {{ $post->content }}
                            </p>
                        </div>
                        <!-- /.post -->
                    </div>
              <!-- /.end reivew -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        @endforeach
        @if ($comments->count() > 0)
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Comments</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                    <!-- Post -->

                    <div class="post">
                    @foreach ($comments as $key=>$comment)
                        <div class="list-group">
                            @if ($comment->parent_id == '')
                            <div href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <p class="mb-1">{{ $comment->content }} <a href="#" class="glyphicon glyphicon-remove text-warning pull-right" data-toggle="modal" data-target="#confirmDeleteComment"></a></p>
                            @endif
                            @if ($comment->children->count())
                                @foreach ($comment->children as $index=>$chil)
                                <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small><small class="text-muted">{{$chil->content}} <a href="#" class="glyphicon glyphicon-remove text-warning pull-right" data-toggle="modal" data-target="#confirmDeleteComment"></a></small>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endforeach
                    </div>
                    <!-- /.post -->
                  </div>
                </div>
            <!-- /.tab-content -->
          </div>
            <!-- /.nav-tabs-custom -->
        </div>
        @endif
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
