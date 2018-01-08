@extends('backend.layouts.main')

@section('title',__('user.user_title'))

@section('content')


<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('user.list_users')  }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('dashboard.home_page')  }}</a></li>
      <li class="active">{{ __('dashboard.users') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ __('user.users_table') }}</h3>
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>{{ __('user.employee_code') }}</th>
                  <th>{{ __('user.employee_name') }}</th>
                  <th>{{ __('user.employee_email') }}</th>
                  <th>{{ __('user.total_donated') }}</th>
                  <th>{{ __('user.total_borrowed') }}</th>
                  @if (session()->get('team') == 'SA')
                  <th>{{ __('user.role') }}</th>
                  @endif
                </tr>
              </thead>
              <tbody>

                @foreach ($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->employee_code }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->total_donated }}</td>
                  <td>{{ $user->total_borrowed }}</td>
                  @if (session()->get('team') == 'SA')
                  <td>
                    <a 
                    @if ($user->team == 'SA')
                    disabled
                    @endif

                    class=" width-70 
                    @if ($user->role)
                    btn btn-success" >Admin
                    @else
                    btn btn-danger" >User
                    @endif
                  </a>
                </td>
                @endif

                @endforeach
              </tr>
            </tbody>

          </table>
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </section>
</div>

<!-- /.content -->
</div>
@endsection
