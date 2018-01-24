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
            <li class="active">{{ __('borrow.users') }}</li>
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        <tr>
                            <td>AT-0001</td>
                            <td>Phu</td>
                            <td>phutran@gmail.com</td>
                            <td>codedao</td>
                            <td>2017-01-17</td>
                            <td>2017-01-19</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
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
