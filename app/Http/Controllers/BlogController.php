<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    function index(Request $request)
    {
        $title = $request->title;

        //Query Builder
        // $blogs = DB::table('blogs')
        //     ->where('title', 'LIKE', '%'.$title.'%')
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);

        //Eloquent ORM
        $blogs = Blog::with(['tags', 'comments', 'image', 'ratings', 'categories'])
            ->where('title', 'LIKE', '%'.$title.'%')
            // ->withTrashed()
            ->orderBy('id', 'asc')
            ->paginate(10);
        // untuk menampilkan data yg disoftdelete gunakan ->withTrashed()
        
        //policy
        // if ($request->user()->cannot('viewAny', Blog::class)) {
        //     abort (403);
        // }
        // custom message policy
        Gate::authorize('viewAny', Blog::class);

        // return auth()->user();
        // return $blogs;
        return view('blog', [
            'blogs' => $blogs,
            'title' => $title
        ]);
    }

    function add()
    {
        $tags = Tag::all();
        return view('blog-add', ['tags' => $tags]);
    }

    function create(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blogs|max:255',
            'description' => 'required'
        ]);

        //Query Builder
        // DB::table('blogs')->insert([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // Jika nama variable input tidak sama dengan database
        // ex:
        // $blog = new Blog();
        // $blog->title = $request->title;
        // $blog->description = $request->keterangan;
        // $blog->save;
        // atau seperti ini
        // Blog::create([
        //      'title' => $request->title,
        //      'description => $request->keterangan
        // ]);

        //upload image
        // buat migrasi  add_image_column_to_blogs_table => colstring 'image' -> nullable 255 after description
        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $name = $file->hashName();
            Storage::putFileAs('images', $file, $name);

            $request['image'] = $name;
        }

        //Eloquent ORM
        $blog = Blog::create($request->all());
        $blog->tags()->attach($request->tags);

        Session::flash('message', 'New Blog Succesfully Added!');

        return redirect()->route('blog');
    }

    function show($id)
    {
        // $blog = DB::table('blogs')->where('id', $id)->first();
        // if (!$blog) {
        //     abort(404);
        // }

        //Eloquent hanya find atau findOrFail
        $blog = Blog::with(['comments', 'tags'])->findOrFail($id);

        return view('blog-detail', [
            'blog' => $blog
        ]);
    }

    function edit(Request $request, $id)
    {
        // $blog = DB::table('blogs')->where('id', $id)->first();
        // if (!$blog) {
        //     abort(404);
        // }

        //Eloquent hanya find atau findOrFail
        $tags = Tag::all();
        $blog = Blog::with('tags')->findOrFail($id);

        //gate
        // Cara 1
        // if(!Gate::allows('update-blog', $blog)) {
        //     abort(403);
        // }
        // Cara 2
        // Gate::authorize('update-blog', $blog);
        // Cara 3
        // $response = Gate::inspect('update-blog', $blog);
        // if (!$response->allowed()) {
        //     abort(403, $response->message());
        // }

        //policy
        // if ($request->user()->cannot('update', $blog)) {
        //     abort (403);
        // }
        // custom message policy
        Gate::authorize('update', $blog);

        return view('blog-edit', [
            'blog' => $blog,
            'tags' => $tags
        ]);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:blogs,title,'.$id.'|max:255',
            'description' => 'required'
        ]);

        // Query Builder
        // DB::table('blogs')
        //     ->where('id', $id)
        //     ->update([
        //         'title' => $request->title,
        //         'description' => $request->description,
        //     ]);

        //Eloquent
        $blog = Blog::findOrFail($id);

        //policy
        // if ($request->user()->cannot('update', $blog)) {
        //     abort (403);
        // }
        // custom message policy
        Gate::authorize('update', $blog);

        //detach tags lama
        // $blog->tags()->detach($blog->tags);
        //attach tags baru
        // $blog->tags()->attach($request->tags);
        //atau bisa pakai sync
        $blog->tags()->sync($request->tags);
        //update
        $blog->update($request->all());

        Session::flash('message', 'Blog Succesfully Updated!');

        return redirect()->route('blog');
    }

    function delete($id)
    {
        // Query Builder
        // $blog = DB::table('blogs')->where('id', $id)->delete();

        // Eloquent
        Blog::findOrFail($id)->delete();

        Session::flash('message', 'Blog Succesfully Deleted!');

        return redirect()->route('blog');
    }

    /**
     * restore data softdelete
     */
    function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id)->restore();
    }
    function test()
    {
        // return 'Ini adalah halaman index Blog';
        // return view('blog');
        // return view('blog', ['data' => 'test data']);
        // $blogs = DB::table('blogs')->get();
        $blogs = DB::table('blogs')->orderBy('title')->paginate(10);
        // dd($blogs);
        return view('blog', ['blogs' => $blogs]);
    }

    function hitung()
    {
        $a = 5;
        $b = 10;
        $c = $a + $b;
        return 'Hasil dari $a ditambah $b adalah ' . $c;
    }
}
