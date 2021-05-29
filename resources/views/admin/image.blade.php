@extends('layouts.app_admin')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">商品新規登録</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('item.add') }}" enctype="multipart/form-data">
					{{ csrf_field() }}

						<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
							<label class="col-md-4 control-label">商品画像</label>
							<div class="col-md-6"><br>
								<a href="{{ route('item.create') }}" class="btn btn-primary btn-xs">後で登録する</a>
								<input type="file" class="form-control" name="image">
								@if ($errors->has('image'))
									<span class="help-block">
									<strong>{{ $errors->first('image') }}</strong>
									</span>
								@endif
							</div>
						</div>

					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">商品名</label>
						<div class="col-md-6"><br>
							<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							@if ($errors->has('name'))
								<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>


					<div class="form-group{{ $errors->has('explain') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">商品説明</label>
						<div class="col-md-6"><br>
							<textarea name="explain" cols="40" rows="3" class="form-control" ></textarea>
							@if ($errors->has('explain'))
								<span class="help-block">
								<strong>{{ $errors->first('explain') }}</strong>
								</span>
							@endif
						</div>

					<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">値段</label>
						<div class="col-md-6"><br>
							<input type="number" class="form-control" name="price" value="{{ old('price') }}">
							@if ($errors->has('price'))
								<span class="help-block">
								<strong>{{ $errors->first('price') }}</strong>
								</span>
							@endif
						</div>
					</div>


					<div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">在庫数</label>
						<div class="col-md-6"><br>
							<input type="number" class="form-control" name="stock" value="{{ old('stock') }}">
							@if ($errors->has('stock'))
								<span class="help-block">
								<strong>{{ $errors->first('stock') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-8 col-md-offset-4">
							<button type="submit" class="btn btn-primary">
								新規登録
							</button>
						</div>
					</div>

					</form>
					<a href="{{ route('admin.item') }}">商品一覧ページに戻る</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
