<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = [
            'commentOpen' => 'menu-open',
            'viewOpen' => 'active'
        ];
        $comments = Comment::orderBy('id', 'desc')->get(); //ordeno todos
        return view('comments.index', ['comments' => $comments, 'array' => $array]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $all = $request->validated();
        // No me sirve por la foto y el user_id que no son del Request
        // $post = new Post($all);

        // //el PostRequest ya viene validado
        $comment = new Comment();

        //del Request pido:
        $comment->text = $request->input('text');
        $comment->email = $request->input('email');

        //TODO guardar la imagen

        try {
            $result = $comment->save();
        } catch (\exception $e) {
            $result = 0;
        }

        if ($comment->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $comment->id];
            return redirect()->route('posts.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('comments.show', ['comment' => $comment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {

        //del Request pido:
        $comment->text = $request->input('text');
        $comment->email = $request->input('email');

        //TODO guardar la imagen

        try {
            $result = $comment->save();
        } catch (\exception $e) {
            $result = 0;
        }

        if ($comment->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $comment->id];
            return redirect()->route('posts.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $post_id = $comment->post_id;
        try {
            $result = $comment->delete();
        } catch (\Exception $ex) {
            $result = 0;
        }
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $comment->id];
        return back()->with($response);
    }
}
