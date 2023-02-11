{{-- <h1>Index Method of Blogs</h1>
<a href={{ route('blog.index', ['id' => 1]) }}>Blog</a> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    {{-- {{ dump($posts) }} --}}
    {{-- @if (count($posts) < 100)
        <h1>{{ $posts }}</h1>
    @elseif (count($posts) === 103)
        <h1>You have exactly 103 posts</h1>
    @else
        <h1>No Posts</h1>
    @endif --}}

    {{-- if(!$posts)  thats same as the below line --}}
    {{-- @unless($posts)
        <h1>Posts have been added</h1>
    @endunless --}}


    @forelse ($posts as $post)
        {{-- <li>{{ $loop->index }}</li> looping starts from 0 --}}
        {{-- <li>{{ $loop->iteration }} looping starts from 1</li> --}}
        {{-- <li>{{ $loop->remaining }}</li> --}}
        {{-- <li>{{ $loop->parent }}</li> --}}
        {{-- <li>{{ $loop->depth }}</li> --}}
        {{-- <li>{{ $loop->first }}</li> --}}
        {{-- <li>{{ $loop->last }}</li> --}}
    @empty
        <li>No items found</li>
    @endforelse


</body>

</html>
