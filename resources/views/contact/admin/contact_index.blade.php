@extends('layouts.app')
@section('content')
@if (session('success'))
<div class="container mt-2">
<div class="alert alert-success">
{{ session('success') }}
</div>
</div>
@endif
@if (session('error'))
<div class="container mt-2">
<div class="alert alert-danger">
{{ session('error') }}
</div>
</div>
@endif
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">お問い合わせ一覧</div>
				<div class="panel-body">

					@foreach($contacts as $contact)
						<a href="{{ route('admin.contact.detail', ['id' => $contact->id]) }}">{{ $contact->title }}</a>
						@if ($contact->item_id > 0)
							(注文した商品について)
						@endif
						<br>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
