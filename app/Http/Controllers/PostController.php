<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BlogCreateRequest;

use App\Post;
use App\Category;
use App\Tag;

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
        $tags       = Tag::all();
        return view('post.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCreateRequest $request)
    {

     //tag creation
        //if new tags are created , we  save them to tags table

        $idOfRequestTags = []; //this array of tags id are needed for syncing to post_tag table

        $existingTags = Tag::lists('id')->all();
        
        
        foreach ($request->tag as $name) {
            if (!in_array($name, $existingTags)) {
              
                $tagSlug = implode('-', explode(" ", $name));

                $newTag = new Tag([
                'name' => $name,
                'slug' => $tagSlug,
                'detail' => "",

                ]);

                 $newTag->save();  
                 $idOfRequestTags[] = $newTag->id;

              }else{

                  $idOfRequestTags[] = $name;

              }

        }
      

    //post creation
     $slug = implode('-', explode(" ", $request->title));
      
      $post = new Post([
           'title' => $request->title,
           'slug'  => $slug,
           'body'  => $request->body,
           'category_id' => $request->category

        ]);
      $post->save();

      $post->tags()->sync($idOfRequestTags, false);


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
        $tags       = Tag::all();
        return view('post.edit')->withPost($post)->withCategories($categories)->withTags($tags);
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
         //tag creation
        //if new tags are created , we  save them to tags table

        $idOfRequestTags = []; //this array of tags id are needed for syncing to post_tag table

        $existingTags = Tag::lists('id')->all();
        
        if($request->tag){
          foreach ($request->tag as $name) {
            if (!in_array($name, $existingTags)) {
              
                $tagSlug = implode('-', explode(" ", $name));

                $newTag = new Tag([
                'name' => $name,
                'slug' => $tagSlug,
                'detail' => "",

                ]);

                 $newTag->save();  
                 $idOfRequestTags[] = $newTag->id;

              }else{

                  $idOfRequestTags[] = $name;

              }
          }
      }

        $slug = implode('-', explode(" ", $request->title));
        $post = Post::find($id);

        $post->fill([
           'title' => $request->title,
           'slug'  => $slug,
           'body'  => $request->body,
           'category_id' => $request->category,

            ]);

        $post->save();
        $post->tags()->sync($idOfRequestTags, true);
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
       $post->tags()->detach();
       $post->delete();
       session()->flash('success', 'Post has been deleted');
       return redirect()->route('post.index');
    }
}
