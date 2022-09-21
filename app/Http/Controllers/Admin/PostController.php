<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $validationRules = [
        'title' => 'required|string|min:3|max:255',
        'author' => 'required|string|min:3|max:255',
        'post_date' => 'required|date',
        'post_content' => 'required|min:3|string',
        'post_image' => 'active_url'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        return view('admin.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sentData = $request->validate($this->validationRules);
        $post = new Post();
        $lastPostId = Post::orderBy('id', 'desc')->first();
        $sentData['slug'] = Str::slug($sentData['title'], '-'). '-' . ($lastPostId->id + 1);
        
        $post->create($sentData);

        return redirect()->route('admin.posts.show', $sentData['slug']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $sentData = $request->validate($this->validationRules);
        $post = Post::where('slug', $slug)->firstOrFail();
        $sentData['slug'] = Str::slug($sentData['title'], '-'). '-' . ($post->id);
        $post->update($sentData);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
