<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TagCreateRequest;
use App\Tag;
use App\Post;

class TagController extends Controller
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
        
        $tags = Tag::orderBy('id', 'desc')->get();
        return view('tag.index')->withTags($tags);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {
        $slug = implode('-', explode(" ", trim($request->name)));
        $tag = new Tag([
            'name' => trim($request->name),
            'slug' => $slug,
            'description' => $request->description,

            ]);

        $tag->save();
        session()->flash('success', 'New tag has been created successfully');
        return redirect()->route('tag.index');

    }
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts;
        return view('tag.show')->withTag($tag)->withPosts($posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
         $tag = Tag::where('slug', $slug)->first();

        return view('tag.edit')->withTag($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
          'name' => 'required|min:3|max:50|unique:tags,name,'.$id,
            ]);
        $slug = implode('-', explode(" ", trim($request->name)));
        $tag = Tag::find($id);
        $tag->fill([
           'name' => trim($request->name),
           'slug' => $slug,
           'description'  => $request->detail

            ]);

        $tag->save();
        session()->flash('success', 'The tag has been updated successfully');
        return redirect()->route('tag.show', $tag->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $tag->posts()->detach();
       $tag->delete();
       session()->flash('success', 'Tag has been deleted');
       return redirect()->route('tag.index');
    }
}
