<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
</head>
<body>
<h4>Post List:</h4>

@if(!empty($posts))
    @foreach ($posts as $post)
        <p>{{ $post->id }}: {{ $post->title }} <br> {!! $post->content !!}</p><hr>
    @endforeach
@endif

</body>
</html>