@extends('backend.layouts.main')
@section('title',__('borrow.title_borrow'))
@section('content')
<!-- Modal -->
@include ('backend.books.partials.modal')
<!-- end modal-->
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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <!-- add form search and select box for borrow -->
                        <!-- start -->
                        <form action="{{ route('borrowings.index') }}" method="GET" id="frm-search-borrow">
                            <div class="form-row">
                                <div class="form-group col-md-6 col-md-push-1">
                                    <input type="text" class="form-control" name="search" placeholder="{{ __('borrow.find_borrow') }}" value="{{ app('request')->input('search') }}">
                                </div>
                                <div class="form-group col-md-2 col-md-push-1">
                                    <select class="form-control" id="filter" name="choose">
                                        @foreach (__('borrow.borrow') as $key => $value)
                                            <option value="{{ $key }}" {{ $key == Request::get('choose') ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-1 col-md-push-1">
                                    <button type="submit" class="btn btn-info form-control" id="search-borrow"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>

        <!-- show message response -->
        <div class="message">
              @if ($errors->has('message'))
                <span class="help-block">
                  <strong>{{ $errors->first('message') }}</strong>
                </span>
              @endif
        </div>
        @include('flash::message')
        
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="table-borrowings" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('employee_code', __('borrow.employee_code'))</th>
                                <th>@sortablelink('user_name', __('borrow.name'))</th>
                                <th>@sortablelink('email', __('borrow.email'))</th>
                                <th>@sortablelink('book_name', __('borrow.books'))</th>
                                <th>@sortablelink('from_date', __('borrow.from_date'))</th>
                                <th>@sortablelink('to_date', __('borrow.end_date'))</th>
                                <th>@sortablelink('date_sent_mail', __('borrow.date_sent_mail'))</th>
                                <th class="text-center text-info">{{ __('general.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($borrowings as $borrowing)
                                <tr>
                                    <td>{{ $borrowing->employee_code }}</td>
                                    <td>{{ $borrowing->user_name }}</td>
                                    <td>{{ $borrowing->email }}</td>
                                    <td>{{ $borrowing->book_name }}</td>
                                    <td>{{ date(config('define.date_format'), strtotime($borrowing->from_date)) }}</td>
                                    <td>{{ $borrowing->to_date == null ? '' : date(config('define.date_format'), strtotime($borrowing->to_date)) }}</td>
                                    <td>{{ $borrowing->date_send_mail }}</td>
                                    <td>
                                        <button type="button" data-action= "{{ route('sendMail', $borrowing->id) }}" 
                                        class="btn btn-warning btn-check fa-trash-o ion ion-android-drafts" data-name="{{ $borrowing->user_name }}" data-toggle="modal" data-target="#confirmSendMail" id="{{ $borrowing->id }}" {{ canSendMail($borrowing->date_send_email) ? '' : 'disabled' }}>
                                        </button>
                                    </td>         
                                </tr>
                            @endforeach
                            <form method="POST" action="" id="form-confirm">
                                {{ csrf_field()}}
                            </form>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="text-center">
                        {{ $borrowings->appends(\Request::except('page'))->appends(['search' => Request::get('search'), 'choose' => Request::get('choose')])->render()}}
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
@section('script')
    <script src="{{ asset('app/js/borrow.js') }}"></script>
@endsection
