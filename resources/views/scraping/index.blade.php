@extends('layouts.app')
@section('content')
<table class="table">
<thead>
<tr>
<th>ユーザー名</th>
<th>総回答数</th>
<th>いいねされた数</th>
<th>回答した質問のURL</th>
</tr>
</thead>
<tbody>
<tr>
<td>
{{ $date['user_name'] }}
</td>
<td>
{{ $date['answerd_count'] }}
</td>
<td>
{{ $date['favorite_count'] }}
</td>
<td>
@foreach ($questions as $question)
<a href="{{ $question }}">{{ $question }}</a><br>
@endforeach
</td>
</tr>
</tbody>
</table>
@endsection
