<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!--<style>body{background-color: tomato;}</style>!--><!--追加!-->
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container"> <div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand" href="{{ route('admin.item') }}">
						Laravel
					</a>
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->

						@if(Auth::guard('admin')->check())
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
									{{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
								</a>

								<ul class="dropdown-menu">
									<li>
										<a href="{{ route('admin.logout') }}"
											onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
											ログアウト
										</a>
										<a href="{{ route('admin.user.index') }}">会員一覧</a>
										<a href="{{ route('admin.user.order') }}">注文履歴</a>
										<a href="{{ route('admin.contact.index') }}">お問い合わせ</a>
										<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</li>
								</ul>
							</li>
						@endguest
							<li><a href="{{ route('user.page') }}">ユーザーページへ</a></li>
					</ul>
				</div>
			</div>
		</nav>

		@yield('content')
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
