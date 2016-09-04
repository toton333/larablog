<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CategoryCreateRequest;
use App\Category;
use App\Post;

class CategoryController extends Controller
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
        //
        $categories = Category::orderBy('id', 'desc')->get();
        return view('category.index')->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->role != 'admin'  ){
           return redirect()->back();
        }
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $slug = implode('-', explode(" ", trim($request->name)));
        $category = new Category([
            'name' => trim($request->name),
            'slug' => $slug,
            'detail' => $request->detail,

            ]);

        $category->save();
        session()->flash('success', 'New category has been created successfully');
        return redirect()->route('category.show', $category->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts;
        return view('category.show')->withCategory($category)->withPosts($posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if(auth()->user()->role != 'admin'  ){
           return redirect()->back();
        }
        $category = Category::where('slug', $slug)->first();

        return view('category.edit')->withCategory($category);
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
           'name' => 'required|min:3|max:50|unique:categories,name,'.$id,
           'detail'  => 'required',

            ]);
        $slug = implode('-', explode(" ", trim($request->name)));
        $category = Category::find($id);
        $category->fill([
           'name' => trim($request->name),
           'slug' => $slug,
           'detail'  => $request->detail

            ]);

        $category->save();
        session()->flash('success', 'The category has been updated successfully');
        return redirect()->route('category.show', $category->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        if(auth()->user()->role != 'admin'  ){
           return redirect()->back();
        }
        $category = Category::where('slug', $slug)->first();
       $category->delete();
       session()->flash('success', 'Category has been deleted');
       return redirect()->route('category.index');
    }
}
