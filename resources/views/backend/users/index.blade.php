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
                @if (session()->get('team') == app\Model\User::SA)
                <td>
                  <a id="role-{{$user->id}}"
                  @if ($user->team == app\Model\User::SA)
                    disabled
                  @endif
                    class=" width-70 
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
  </section>
</div>
<!-- /.content -->
</div>
@endsection
@section('javascript')
  <script type="text/javascript">
    $classbtn = document.getElementsByClassName('btn');
    for (let $eachbtn of $classbtn) {
      if($eachbtn.getAttribute('disabled') !== '') {
        $eachbtn.addEventListener('click', function () {
          let $id = $eachbtn.getAttribute('id').slice(5);
          $.ajax({
            type:'GET',
            url: '/admin/users/changeRole/' + $id,
            data:{
            },
            success: function(data){
              $btnRole = document.getElementById('role-' + $id);
              if (data.user.role === 0) {
                $btnRole.innerHTML = "{{ __('user.user') }}";
                $btnRole.setAttribute('class', 'width-70 btn btn-danger');
              } else {
                $btnRole.innerHTML = "{{ __('user.admin') }}";
                $btnRole.setAttribute('class', 'width-70 btn btn-success');
              }
            }
          });
        });
      };
    }
  </script>
@endsection