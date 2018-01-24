@extends('backend.layouts.main')
@section('title',__('borrow.title_borrow'))
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __('borrow.list_borrowers')  }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('borrow.admin')  }}</a></li>
            <li class="active">{{ __('borrow.borrowings') }}</li>
        </ol>
    </section>
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('borrow.employee_code') }}</th>
                            <th>{{ __('borrow.name') }}</th>
                            <th>{{ __('borrow.email') }}</th>
                            <th>{{ __('borrow.books') }}</th>
                            <th>{{ __('borrow.from_date') }}</th>
                            <th>{{ __('borrow.end_date') }}</th>
                            <th>{{ __('borrow.date_sent_mail') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->employee_code }}</td>
                                <td>{{ $borrowing->name }}</td>
                                <td>{{ $borrowing->email }}</td>
                                <td>{{ $borrowing->name }}</td>
                                <td>{{ $borrowing->from_date }}</td>
                                <td>{{ $borrowing->to_date }}</td>
                                <td id="{{ $borrowing->id }}" class="align-center">
                                    @if (isset($borrowing->date_send_email))
                                        <a href="{{ route('sendMail') }}">{{Carbon\Carbon::parse($borrowing->date_send_email)->format('H:i:s d-m-Y')}}</a>
                                    @else
                                        <a href="{{ route('sendMail') }}" id="{{ $borrowing->id }}" class="btn btn-warning"><i class="ion ion-android-drafts"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="text-center">
                    {{ $borrowings->render() }}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->
@endsection
