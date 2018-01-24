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
                            <th>@sortablelink('users.employee_code', __('borrow.employee_code'))</th>
                            <th>@sortablelink('users.name', __('borrow.name'))</th>
                            <th>@sortablelink('users.email', __('borrow.email'))</th>
                            <th>@sortablelink('books.name', __('borrow.books'))</th>
                            <th>@sortablelink('from_date', __('borrow.from_date'))</th>
                            <th>@sortablelink('to_date', __('borrow.end_date'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->users->employee_code }}</td>
                                <td>{{ $borrowing->users->name }}</td>
                                <td>{{ $borrowing->users->email }}</td>
                                <td>{{ $borrowing->books->name }}</td>
                                {{--<td>{{ $borrowing->from_date $OpenOrders->OPEN_TIME->format('d-m-Y') }}</td>--}}
                                <td>{{ date('d-m-Y H-m-i',strtotime($borrowing->from_date)) }}</td>
                                <td>{{ date('d-m-Y H-m-i',strtotime($borrowing->to_date)) }}</td>
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
