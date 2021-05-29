<!DOCTYPE html>
<html lang="ja">
<body>
<p>{{ $user['name'] }}様からお問い合わせがありました</p>
<a href="{{ route('admin.user.detail', ['id' => $contact['user_id']]) }}">お客様情報はこちら</a><br>
<br>
タイトル<br>
{{ $contact['title'] }}<br>
<br>
内容<br>
{{ $contact['content'] }}
</body>
</html>
