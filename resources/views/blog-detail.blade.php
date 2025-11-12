<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    #desc-textarea {
        resize: none;
    }
</style>
<body>
    <div class="container">
        <div class="mt-5">
            <h2 class="text-center">Blog Detail {{ $blog->id }}</h2>
            <div class="blog-body">
                @if ($blog->image)
                <div class="my-3">
                    <img src="{{asset('storage/images/'.$blog->image)}}" 
                        class="img-fluid rounded object-fit-cover w-100" 
                        style="max-width: 400px; height: 250px;"
                        alt="{{ $blog->title }}">
                </div>
                @endif

                <p>
                    {{ $blog->description }}
                </p>

                <div class="mt-5">
                    tags: {{ $blog->tags->count() < 1 ? '-' : '' }}
                    @foreach ( $blog->tags as $tag)
                    <span class="p-2 bg-secondary text-white rounded me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <div class="d-flex flex-column align-items-end">
                    <div>{{ $blog->created_at }}</div>
                    <div>by {{ $blog->author->name ?? 'Admin'}}</div>
                </div>
            </div>
        </div>

        <div class="mt-5">
           @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h5>Comment :</h5>
            <form action="{{ url('comment/'.$blog->id) }}" method="POST">
                @csrf
                <textarea name="comment_text" class="form-control" rows="5"></textarea>
                <button class="btn btn-primary mt-3" type="submit">Submit</button>
            </form>
        </div>

        <hr class="mt-5">

        <div class="mt-5">
            {{ $blog->comments->count() == 0 ? 'No comments yet.' : '' }}

            @foreach ($blog->comments as $comment)
            <div class="p-3 mb-3 rounded" style="background-color: azure;">
                {{ $comment->comment_text }}
            </div>
            @endforeach
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>