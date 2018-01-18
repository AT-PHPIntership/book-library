@extends('backend.layouts.main')
@section('title',__('user.user_title'))
@section('content')
<script type="text/javascript">
  $name_role = {!! json_encode(trans('user.name_role')) !!};
</script>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('user.list_users')  }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('user.admin')  }}</a></li>
      <li class="active">{{ __('user.users') }}</li>
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
                  <th>{{ __('user.id') }}</th>
                  <th>{{ __('user.employee_code') }}</th>
                  <th>{{ __('user.employee_name') }}</th>
                  <th>{{ __('user.employee_email') }}</th>
                  <th>{{ __('user.total_donated') }}</th>
                  <th>{{ __('user.total_borrowed') }}</th>
                  @if (session()->get('team') == app\Model\User::SA)
                  <th>{{ __('user.role') }}</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->employee_code }}</td>
                  <td><a href="{{ route('users.show', ['employeeCode' => $user->employee_code])}}">{{ $user->name }} </a></td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->total_donated }}</td>
                  <td>{{ $user->total_borrowed }}</td>
                  @if (session()->get('team') == App\Model\User::SA)
                  <td>
                    <a id="role-{{$user->id}}"
                    @if ($user->team == App\Model\User::SA)
                      disabled
                    @endif
                      class="update width-70
                    @if ($user->role)
                      btn btn-success"> {{ __('user.admin') }}
                    @else
                      btn btn-danger">{{ __('user.user') }}
                    @endif
                    </a>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
            {{ $users->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.content -->
@endsection
@section('script')
  <script src="{{ asset('app/js/user.js') }}">
  </script>
  <script>
    $new_user.update_role();
  </script>
@endsection
