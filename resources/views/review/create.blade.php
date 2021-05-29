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

				<div class="panel-heading">商品レビュー</div>
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
					<form class="form-horizontal" method="POST" action="{{ route('review.send') }}">
						{{ csrf_field() }}

						<input type="hidden" name="item_id" value="{{ $item->id }}">
						<div class="form-group">
							<label class="col-md-4 control-label">商品名</label>
							<div class="col-md-8">
								<label class="col-md-4 control-label">{{ $item->name }}</label>
							</div>
						</div>

						<div class="form-group">
							<label for="title" class="col-md-4 control-label">評価</label>
							<div class="col-md-6">
								@foreach(config('score') as $key => $score)
									<input type="radio" name="score" value="{{ $key }}">{{ $score }}<br>
								@endforeach
							</div>
						</div>

						<div class="form-group">
							<label for="content" class="col-md-4 control-label">コメント</label>
							<div class="col-md-6">
								<textarea class="form-control" rows="10" cols="10"  name="comment">{{ old('comment') }}</textarea>
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
