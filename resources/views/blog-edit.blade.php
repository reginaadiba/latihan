<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h2>Edit Blog: {{ $blog->id }}</h2>

            @if ($errors->any())
                <div class="alert alert-danger col-md-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('blog/'.$blog->id.'/update') }}">
                @csrf
                @method('PATCH')
                <div class="col-md-6">
                    <label for="title" class="form-label">Title :</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}">
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description :</label>
                    <textarea class="form-control" name="description" id="desc-textarea" rows="5">
                        {{ $blog->description }}
                    </textarea>
                </div>
                <div class="mt-3">
                    tags: {{ $blog->tags->count() < 1 ? '-' : '' }}
                    @foreach ( $blog->tags as $tag)
                    <span class="p-2 bg-secondary text-white rounded me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="col-md-6 mt-3">
                    <label for="title" class="form-label">Tags :</label>
                    @foreach ($tags as $key => $tag)
                    <div>
                    <input type="checkbox" name="tags[]" id="tag{{ $key }}" value="{{ $tag->id }}">
                    <label class="form-check-label" for="tag{{ $key }}">{{ $tag->name }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-6 mt-3">
                    <button class="btn btn-success form-control">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>