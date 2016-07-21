<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BlogCreateRequest;

use App\Post;
use App\Category;

class PostController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return view('post.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCreateRequest $request)
    {
     $slug = implode('-', explode(" ", $request->title));
      
      $post = new Post([
           'title' => $request->title,
           'slug'  => $slug,
           'body'  => $request->body,
           'category_id' => $request->category

        ]);


      $post->save();
      session()->flash('success', 'The blog post was successfully created!');
      return redirect()->route('post.show', $post->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('post.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $categories = Category::all();
        return view('post.edit')->withPost($post)->withCategories($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $slug = implode('-', explode(" ", $request->title));
        $post = Post::find($id);

        $post->fill([
           'title' => $request->title,
           'slug'  => $slug,
           'body'  => $request->body,
           'category_id' => $request->category,

            ]);

        $post->save();
        session()->flash('success', 'The post has been updated successfully');
        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
       $post = Post::where('slug', $slug)->first();
       $post->delete();
       session()->flash('success', 'Post has been deleted');
       return redirect()->route('post.index');
    }
}
