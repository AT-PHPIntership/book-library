@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">User info</div>
                <div class="panel-body">
                    <div class="user">{{ $user->name }}</div>
                    <div class="user">{{ $user->email }}</div>
                    <div class="user">{{ $user->team }}</div>
                    <div class="">
                        <img style="width: 60px;height: 60px;object-fit: cover;border: 6px solid #fff;border-radius: 50%;" src="{{ $user->avatar_url }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
