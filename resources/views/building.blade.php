<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	@if(!isset($buildings[0]) or !isset($rooms[0]))
		※値がありません。
	@else
		※値が存在します。
    <!-- @foreach($buildings as $building)
        {{@$building}}
    @endforeach -->
	@endif
</body>
</html>