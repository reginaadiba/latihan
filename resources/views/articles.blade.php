<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Articles List</h2>

        <div class="mt-5 table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Rating</th>
                    <!-- <th>Action</th> -->
                </thead>
                <tbody class="table-group-divider">
                    @if ($articles->count() == 0)
                        <tr>
                            <td colspan="3" class="text-center">No data found with <strong>{{ $title }}</strong> keyword.</td>
                        </tr>                        
                    @endif
                    @foreach ($articles as $article) 
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->image->name ?? '' }}</td>
                            <td>
                                @if ($article->ratings->count() < 1)
                                    not rated yet
                                @else
                                    {{ collect($article->ratings->pluck('rating_value'))->avg()}}
                                @endif
                            </td>
                                <!-- <td>
                                    <a href="{{ url('article/'.$article->id.'/detail') }}">View</a> | 
                                    <a href="{{ url('article/'.$article->id.'/edit') }}">Edit</a> | 
                                    <a href="{{ url('article/'.$article->id.'/delete') }}">Delete</a>
                                </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>