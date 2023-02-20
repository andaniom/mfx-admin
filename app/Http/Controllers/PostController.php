<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')->paginate(5);
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.form');
    }

    public function edit(Post $post)
    {
        return view('posts.form', compact(['post']));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'files' => 'required',
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

        $paths = [];
        //upload image
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $file->storeAs('public/posts', $file->hashName());
                $paths[] = $file->hashName();
            }
        }

        $content = $request->contentTiny;

        $post = new Post;
        $post->photo = implode(', ', $paths);
        $post->title = $request->title;
        $post->author = $request->author;
        $post->description = $request->description;
        $post->date = now();
        $post->content = $content;
        $post->save();

        if ($post) {
            return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('posts.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'files' => 'required',
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

        $paths = [];
        //upload image
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $file->storeAs('public/posts', $file->hashName());
                $paths[] = $file->hashName();
            }
        }

        $content = $request->contentTiny;

        $post->photo = implode(', ', $paths);
        $post->title = $request->title;
        $post->author = $request->author;
        $post->description = $request->description;
        $post->date = now();
        $post->content = $content;
        $post->save();

        if ($post) {
            return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('posts.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function show(Request $request, $key)
    {
        $post = Post::find($key);
        return view('posts.show', ['post' => $post]);
    }

    public function destroy($key)
    {
        $post = Post::find($key);
        $post->delete();
        if ($post) {
            return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('posts.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
