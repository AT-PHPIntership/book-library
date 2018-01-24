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
              <img class="img-thumbnail" src="{{ asset('images/books/no-image.png')}}" alt="User profile picture">
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">{{ __('post.review') }}</a></li>
              <li><a href="#timeline" data-toggle="tab">{{ __('post.status') }}</a></li>
              <li><a href="#settings" data-toggle="tab">{{ __('post.find_book') }}</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                  <div>
                        <span class="username">
                         <a href="#" class="h2">Jonathan Burke Jr.</a></br>
                        </span>
                        <ol class="breadcrumb">
                          <li><b>{{ __('post.by') }} </b><i>User </i></li>
                          <li><b>{{ __('post.score') }} :</b><i>9</i></li>
                          <li><b>{{ __('post.date') }} :</b><i> 20.10.2017</i></li>
                          <li><i class="fa fa-trash-o text-danger"></i></li>
                        </ol>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    Lorem ipsum represents a long-held tradition for designers,
                    typographers and the like. Some people hate it and argue for
                    its demise, but others ignore the hate as they create awesome
                    tools to help create filler text for everyone from bacon lovers
                    to Charlie Sheen fans.
                  </p>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                  <!-- Post -->
                  <div class="post">
                    <div>
                          <span class="username">
                           <a href="#">Jonathan Burke Jr.</a></br>
                          </span>
                          <ol class="breadcrumb">
                            <li><b>{{ __('post.by') }} </b><i>User </i></li>
                            <li><b>{{ __('post.score') }} :</b><i>9</i></li>
                            <li><b>{{ __('post.date') }} :</b><i> 20.10.2017</i></li>
                            <li><i class="fa fa-trash-o text-danger"></i></li>
                          </ol>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      Lorem ipsum represents a long-held tradition for designers,
                      typographers and the like. Some people hate it and argue for
                      its demise, but others ignore the hate as they create awesome
                      tools to help create filler text for everyone from bacon lovers
                      to Charlie Sheen fans.
                    </p>
                  </div>
                  <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="settings">
                  <!-- Post -->
                  <div class="post">
                    <div>
                          <span class="username">
                           <a href="#">Jonathan Burke Jr.</a></br>
                          </span>
                          <ol class="breadcrumb">
                            <li><b>{{ __('post.by') }} </b><i>User </i></li>
                            <li><b>{{ __('post.score') }} :</b><i>9</i></li>
                            <li><b>{{ __('post.date') }} :</b><i> 20.10.2017</i></li>
                            <li><i class="fa fa-trash-o text-danger"></i></li>
                          </ol>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      Lorem ipsum represents a long-held tradition for designers,
                      typographers and the like. Some people hate it and argue for
                      its demise, but others ignore the hate as they create awesome
                      tools to help create filler text for everyone from bacon lovers
                      to Charlie Sheen fans.
                    </p>
                  </div>
                  <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Comments</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                    <table class="table">
                     <tbody>
                       <tr>
                         <th scope="row">1</th>
                         <td>Mark</td>
                         <td><a href="#" class="pull-right btn-box-tool"><i class="btn btn-danger fa fa-trash-o text-danger"></i></i></a></td>
                       </tr>
                       <tr>
                         <th scope="row">2</th>
                         <td>Jacob</td>
                         <td><a href="#" class="pull-right btn-box-tool"><i class="btn btn-danger fa fa-trash-o text-danger"></i></a></td>
                       </tr>
                     </tbody>
                    </table>
                </div>
                <!-- /.post -->
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
