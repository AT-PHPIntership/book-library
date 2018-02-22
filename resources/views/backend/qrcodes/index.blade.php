@extends('backend.layouts.main')
@section('title', __('qrcode.title'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('qrcode.title') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i>{{ __('qrcode.admin') }}</a></li>
            <li class="active">{{ __('qrcode.qrcodes') }}</li>
        </ol>
    </section>

    <section class="content">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover" id="table-qrcodes">
                            <thead>
                                <tr>
                                    <th>{{ __('qrcode.id') }}</th>
                                    <th>{{ __('qrcode.name_of_book') }}</th>
                                    <th>{{ __('qrcode.author') }}</th>
                                    <th>{{ __('qrcode.qrcodes') }}</th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach ($qrcodes as $qrcode)
                                <tr>
                                    <td>{{ $qrcode->id }}</td>
                                    <td>{{ $qrcode->name }}</td>
                                    <td>{{ $qrcode->author }}</td>
                                    <td>{{ $qrcode->QrcodeBook }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- .pagination -->
            <div class="text-center">
              <nav aria-label="...">
                {{ $qrcodes->links() }}
              </nav>
            </div>
            <!-- /.pagination -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb1 bg-olive pull-right" href="{{ route('qrcodes.export') }}">{{ __('qrcode.export') }}</a>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
