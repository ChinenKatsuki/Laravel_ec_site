eextends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">

				<div class="panel-heading"> 商品に関するお問い合わせ</div>
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
					<form class="form-horizontal" method="POST" action="{{ route('order.content.send') }}">
						{{ csrf_field() }}
						<input type="hidden" name="item_id" value="{{ $order->item_id}}">
						<input type="hidden" name="order_id" value="{{ $order->id}}">

						<div class="form-group">
							<label class="col-md-4 control-label">商品名</label>
							<div class="col-md-8">
							<label class="col-md-4 control-label">{{ $item->name }}</label>
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
								<textarea class="form-control" rows="10" cols="10" name="content">{{ old('content') }}</textarea>
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
