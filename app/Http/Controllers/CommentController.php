<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CommentCreateRequest;

use App\User;
use App\Post;
use App\Comment;

class CommentController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentCreateRequest $request)
    {
     $comment = new Comment([
        'user_id' => auth()->id(),
        'post_id' => $request->post_id,
        'comment' => $request->comment

        ]);

     $comment->save();
     session()->flash('success', 'Comment has been posted');

     return redirect()->route('post.show', $request->post_slug);





    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comment.edit')->withComment($comment);
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
        $comment = Comment::find($id);
        $comment->fill([
            'comment' => $request->comment,
            ]);
        $comment->save();
        session()->flash('success', 'comment has been updated');
        return redirect()->route('post.show', $request->post_slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        session()->flash('success', 'Comment has been deleted');
        return "true";
    }
}
