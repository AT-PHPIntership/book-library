@extends('backend.layouts.main')
@section('title',__('post.post_title'))
@section('content')
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
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
                  <img class="img-thumbnail" src="{{ asset('images/books/'.$post->image_url) }}" alt="User profile picture">
            </div>
            <!-- End Profile Image -->
          </div>
        </div>
        <div class="col-md-9">
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
                                        <i> {{$post->rating}} </i>
                                    </li>
                                @endif
                                <li><b>{{ __('post.date') }} :</b><i> {{ $post->created_at }}</i></li>
                                <li><i class="fa fa-trash-o text-danger"></i></li>
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
                    <!-- /.Comment -->
                  </div>
                </div>
          </div>
        </div>

      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
@endsection
