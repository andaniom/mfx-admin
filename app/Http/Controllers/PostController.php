<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')->paginate(5);
        return view('post.posts', ['posts' => $posts]);
    }

    public function create()
    {
        return view('post.post-create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:png,jpg,jpeg',
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

        //upload image
        $image = $request->file('photo');
        $image->storeAs('public/posts', $image->hashName());

        $content = $request->contentTiny;

        $post = new Post;
        $post->photo = $image->hashName();
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

    public function detail(Request $request, $key)
    {
        $post = Post::find($key);
        return view('post.post-detail', ['post' => $post]);
    }

    public function delete($key)
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
