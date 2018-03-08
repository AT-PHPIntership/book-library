@extends('backend.layouts.main')
@section('title',__('user.user_title'))
@section('content')
<script type="text/javascript">
  nameRole = {!! json_encode(trans('user.name_role')) !!};
</script>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('user.list_users')  }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i>{{ __('user.admin')  }}</a></li>
      <li class="active">{{ __('user.users') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
         <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>{{ __('user.id') }}</th>
                <th>{{ __('user.employee_code') }}</th>
                <th>{{ __('user.employee_name') }}</th>
                <th>{{ __('user.employee_email') }}</th>
                <th class="text-center">{{ __('user.total_donated') }}</th>
                <th class="text-center">{{ __('user.total_borrowed') }}</th>
                @if (Auth::user()->team == App\Model\User::SA)
                <th>{{ __('user.role') }}</th>
                @endif
              </tr>
            </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->employee_code }}</td>
                  <td><a class="username" href="{{ route('users.show', ['employeeCode' => $user->employee_code])}}">{{ $user->name }} </a></td>
                  <td>{{ $user->email }}</td>
                  <td class="text-center"><a class="bookuser" id="donator-id" href="{{ route('books.index',['uid' => $user->id, 'filter' => App\Model\Book::DONATED]) }}">{{ $user->total_donated }}</td>
                  <td class="text-center"><a class="bookuser" href="{{ route('books.index',['uid' => $user->id, 'filter' => App\Model\Book::BORROWED]) }}">{{ $user->total_borrowed }}</td>
                  @if (Auth::user()->team == App\Model\User::SA)
                  <td>
                    <a id="role-{{$user->id}}"
                    @if ($user->team == App\Model\User::SA)
                      disabled
                    @endif
                      class="btn-change-role width-70 btn
                    @if ($user->role)
                      btn-success"> {{ __('user.admin') }}
                    @else
                      btn-danger">{{ __('user.user') }}
                    @endif
                    </a>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- .pagination -->
            <div class="text-center">
              <nav aria-label="...">
                <ul class="pagination">
                  @if($users instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{  $users ->links() }}
                  @endif
                </ul>
              </nav>
            </div>
            <!-- /.pagination -->
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
    newUser.updateRole();
  </script>
@endsection
