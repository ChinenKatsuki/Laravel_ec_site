@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">詳細</div>
				<div class="panel-body">
						@if ($item)
						商品名<br>
						{{ $item->name }}<br>
						@endif
						<br>
						タイトル<br>
						{{ $contact->title }}<br>
						<br>
						お問い合わせ内容<br>
						{{ $contact->content }}<br>
						<br>
						@if ($contact->email)
						ご連絡先<br>
						{{ $contact->email }}<br>
						@endif
						<br>
						お問い合わせ時間<br>
						{{ $contact->created_at }}<br>
						<a href="{{ route('admin.user.detail', ['id' => $contact->user_id]) }}">お客様情報はこちら</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
