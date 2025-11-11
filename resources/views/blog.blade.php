<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center">Blog List</h1>

            <div class="table-responsive mt-5">
                <a href="{{ url('blog/add') }}" class="btn btn-primary mb-3">Add New</a>

                @if(Session::has('message'))
                <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="title" value="{{ $title }}" class="form-control" placeholder="Search Title" aria-label="Recipient’s username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
                <table class="table table-striped table-hover">
                    <thead>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Categories</th>
                        <th>Rating</th>
                        <th>Comments</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @if ($blogs->count() == 0)
                            <tr>
                                <td colspan="3" class="text-center">No data found with <strong>{{ $title }}</strong> keyword.</td>
                            </tr>                        
                        @endif
                        @foreach ($blogs as $blog) 
                            <tr>
                                <td>{{ ($blogs->currentpage()-1) * $blogs->perpage() + $loop->index + 1 }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->author->name ?? '-' }}</td>
                                <td>{{ $blog->image->name ?? '' }}</td>
                                <td>
                                    @foreach ($blog->tags as $tag)
                                    <div>{{ $tag->name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($blog->categories as $category)
                                    <div>{{ $category->name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($blog->ratings->count() < 1)
                                        not rated yet
                                    @else
                                        {{ collect($blog->ratings->pluck('rating_value'))->avg()}}
                                    @endif
                                </td>
                                <td>
                                    @foreach ($blog->comments as $comment)
                                    <div>{{ $comment->comment_text }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ url('blog/'.$blog->id.'/detail') }}">View</a> | 
                                    <a href="{{ url('blog/'.$blog->id.'/edit') }}">Edit</a> | 
                                    <a href="{{ url('blog/'.$blog->id.'/delete') }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- <ol>
                @foreach ($blogs as $blog) 
                    <li>{{ $blog->title }}</li>
                @endforeach
            </ol> -->
        </div>
        {{ $blogs->links() }}
        
        <!-- <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">Column 1</th>
                        <th scope="col">Column 2</th>
                        <th scope="col">Column 3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row">R1C1</td>
                        <td>R1C2</td>
                        <td>R1C3</td>
                    </tr>
                    <tr class="">
                        <td scope="row">Item</td>
                        <td>Item</td>
                        <td>Item</td>
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>