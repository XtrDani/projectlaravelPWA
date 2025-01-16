<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to All Posts</a>
    </div>
    @endsection

</body>

</html>