<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BlogCreateRequest;

use App\Like;
use App\Post;
use App\Category;
use App\Tag;
use App\Comment;
use Image;
use Storage;

class PostController extends Controller
{

    public function __construct(){

        $this->middleware('auth')->except('landing');
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
      if(auth()->user()->role != 'subscriber'){
        $categories = Category::all();
        $tags       = Tag::all();
        return view('post.create')->withCategories($categories)->withTags($tags);
         }else{
          return redirect()->back();
         }
    }

    /*
     * If new tags are created we save them in tags table
     * @param  \Illuminate\Http\Request  $request
    */

    public function tagCreation($request)
    {

        $idOfRequestTags = []; //this array of tags id are needed for syncing to post_tag table

        
        
        if($request->tag){
            
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

        }
       

        return $idOfRequestTags;
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
        $idOfRequestTags = $this->tagCreation($request);

    //post creation
     $slug = implode('-', explode(" ", strip_tags(trim($request->title))));
      
      $post = new Post([
           'title' => strip_tags(trim($request->title)),
           'slug'  => $slug,
           'body'  => clean($request->body),
           'category_id' => $request->category,
           'user_id'  => $request->user()->id, //$request always has current authenticated user

        ]);
      if($request->hasFile('featured_image')){
        $image = $request->file('featured_image');
        $filename = time().'.'.$image->getClientOriginalExtension();
        $location = public_path('images/'.$filename);
        Image::make($image)->resize(700, 400)->save($location);
        $post->image = $filename;

      }

      $post->save();
      
       // $request->user()->posts()->save($post);

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
        $post->view = $post->view +1;
        $post->update();

        $comments = $post->comments()->orderBy('id', 'desc')->get();
        return view('post.show')->withPost($post)->withComments($comments);
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

        if(auth()->user()->role  == 'admin'  or $post->user->id == auth()->user()->id){
          $categories = Category::all();
          $tags       = Tag::all();
          return view('post.edit')->withPost($post)->withCategories($categories)->withTags($tags);

       }else{

        return redirect()->back();

      }
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
        $this->validate($request,[
           'title' => 'required|min:3|max:50|unique:posts,title,'.$id,
           'body'  => 'required',
           'featured_image' => 'sometimes|image',

            ]);
         //tag creation
        //if new tags are created , we  save them to tags table

       $idOfRequestTags = $this->tagCreation($request);

        $slug = implode('-', explode(" ", strip_tags(trim($request->title))));
        $post = Post::find($id);



        $post->fill([
           'title' => strip_tags(trim($request->title)),
           'slug'  => $slug,
           'body'  => clean($request->body),
           'category_id' => $request->category,

            ]);

        if($request->hasFile('featured_image')){
          $image = $request->file('featured_image');
          $filename = time().'.'.$image->getClientOriginalExtension();
          $location = public_path('images/'.$filename);
          Image::make($image)->resize(700, 400)->save($location);
          $oldfilename = $post->image;
          $post->image = $filename;
          Storage::delete($oldfilename);

        }


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

         if(auth()->user()->role  == 'admin'  or $post->user->id == auth()->user()->id){
           $post->tags()->detach();
           if(! $post->comments->isEmpty()){
               foreach ($post->comments as $comment) {
                   $comment->delete();
               }
           }
            if(! $post->likes->isEmpty()){
               foreach ($post->likes as $like) {
                   $like->delete();
               }
           }
           Storage::delete($post->image);
           $post->delete();
           session()->flash('success', 'Post has been deleted');
           return "true";
       }else{
        return redirect()->back();
       }
    }



    public function like(Request $request){

      $post_id = $request['postId'];
      
        $is_like = $request['isLike'] == 'true';
        
        $update = false;
        $post = Post::find($post_id);

        
        if (!$post) {
            return null;
        }
        $user = auth()->user();
       
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
   
    }

    public function landing(){

      $posts = Post::orderBy('id', 'desc')->get();
      return view('landing')->withPosts($posts);
    }

}
