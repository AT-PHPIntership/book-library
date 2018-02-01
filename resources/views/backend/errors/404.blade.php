@extends('backend.layouts.main')
@section('title',__('books.title_book'))
<link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css"  media="all" />

@section('content')
	<div class="content-wrapper">
		<!---start-header---->
		<div class="header">
			<div class="logo">
				<h1><a href="#">Asian Tech Book Library</a></h1>
			</div>
		</div>
		<!---End-header---->
		<!--start-content------>
		<div class="content">
			<img src="{{ asset('/images/errors/error-img.png') }}" title="error" />
			<p><span><label>O</label>hh.....</span>You Requested the page that is no longer There.</p>
			<a href="{{ route('home.index')}}">Go Back Home</a>
			</div>
		<!--End-Cotent------>
	</div>
@endsection
