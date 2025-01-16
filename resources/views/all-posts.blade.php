<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
</head>

<body>
    <h1>All Posts</h1>
    @foreach ($posts as $post)
        <div style="border: 3px solid black; margin: 20px; padding: 10px;">
            <h2>{{ $post->title }}</h2>
            <p>By: {{ $post->user->name }}</p>
            <p>{{ $post->body }}</p>

            <div>
                <form action="/post/{{ $post->id }}/upvote" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Upvote</button>
                </form>
                <form action="/post/{{ $post->id }}/downvote" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Downvote</button>
                </form>
                <p>Upvotes: {{ $post->upvotes->count() }} | Downvotes: {{ $post->downvotes->count() }}</p>
            </div>

            <h3>Comments:</h3>
            @foreach ($post->comments as $comment)
                <div style="margin-left: 20px; border: 1px solid gray; padding: 5px;">
                    <p>{{ $comment->body }}</p>
                    <small>By: {{ $comment->user->name }}</small>
                </div>
            @endforeach

            @auth
                <form action="/post/{{ $post->id }}/comment" method="POST" style="margin-top: 10px;">
                    @csrf
                    <textarea name="body" placeholder="Write a comment..." required></textarea>
                    <button>Add Comment</button>
                </form>
            @endauth
        </div>
    @endforeach
</body>

</html>