<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center">Users List</h1>

            <div class="table-responsive mt-5">
                <a href="{{ url('user/add') }}" class="btn btn-primary mb-3">Add New</a>

                @if(Session::has('message'))
                <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="name" value="{{ $name }}" class="form-control" placeholder="Search Name" aria-label="Recipient’s username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
                <table class="table table-striped table-hover">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <!-- <th>Action</th> -->
                    </thead>
                    <tbody class="table-group-divider">
                        @if ($users->count() == 0)
                            <tr>
                                <td colspan="3" class="text-center">No data found with <strong>{{ $name }}</strong> keyword.</td>
                            </tr>                        
                        @endif
                        @foreach ($users as $user) 
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone->phone_number ?? '-'}}</td>
                                <!-- <td>
                                    <a href="{{ url('user/'.$user->id.'/detail') }}">View</a> | 
                                    <a href="{{ url('user/'.$user->id.'/edit') }}">Edit</a> | 
                                    <a href="{{ url('user/'.$user->id.'/delete') }}">Delete</a>
                                </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- <ol>
                @foreach ($users as $user) 
                    <li>{{ $user->title }}</li>
                @endforeach
            </ol> -->
        </div>
        
        
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