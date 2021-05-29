
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

				<div class="panel-heading">お問い合わせ</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('content.send') }}">
						{{ csrf_field() }}

						<div class="form-group">
						<label for="title" class="col-md-4 control-label">件名</label>
							<div class="col-md-6">
						<select name="order_detail_id" class="form-control">
							<option value="0">注文以外に関する問い合わせ</option>
							@foreach ($items as $item)
								<option value="{{ $item->id }}">{{ $item->name }}&ensp;注文日時:{{ $item->created_at }}</option>
							@endforeach
						</select>
						</div>
						</div>

						<div class="form-group">
							<label for="title" class="col-md-4 control-label">タイトル</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="title" value="{{ old('title') }}">
							</div>
						</div>

						<div class="form-group">
							<label for="content" class="col-md-4 control-label">内容</label>
							<div class="col-md-6">
								<textarea class="form-control" rows="10" cols="10"  name="content">{{ old('content') }}</textarea>
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									送信
								</button>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
