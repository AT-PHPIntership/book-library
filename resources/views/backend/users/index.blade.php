@extends('backend.layouts.main')
@section('title',__('user.user_title'))
@section('content')

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
                  <td><a class="username" href="{{ route('users.show', ['employeeCode' => $user->employee_code])}}">{{ $user->name }} </a></td>
                  <td>{{ $user->email }}</td>
                  <td class="text-center"><a href="{{ route('books.index',['uid' => $user->id, 'filter' => App\Model\Book::DONATED]) }}">{{ $user->total_donated }}</td>
                  <td class="text-center"><a class="total" href="{{ route('books.index',['uid' => $user->id, 'filter' => App\Model\Book::BORROWED]) }}">{{ $user->total_borrowed }}</td>
                  @if (session()->get('team') == App\Model\User::SA)
                  <td>
                    <a 
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
            <!-- .pagination -->
            <div class="text-right">
              <nav aria-label="...">
                  <ul class="pagination">
                      {{ $users->links() }}
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
    <script type="text/javascript" src="{{ asset('app/js/user.js') }}"></script>
    <script type="text/javascript">
        UserComponent.changeRole();
    </script>
@endsection
