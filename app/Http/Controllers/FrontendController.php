<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10); //ordeno todos
        return view('frontend.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->get();//para pasar los comentarios al post
        return view('frontend.show', ['post' => $post, 'comments' => $comments]);
    }

    public function store(CommentRequest $request)
    {
        
        // $all = $request->validated();
        // No me sirve por la foto y el user_id que no son del Request
        // $post = new Post($all);

        // //el PostRequest ya viene validado
        $comment = new Comment();
        $comment->email = $request->email;
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        

        try {
            $result = $comment->save();
            
        } catch (\exception $e) {
            $result = 0;
        }

        if ($comment->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $comment->id];
            return redirect()->route('frontend.show' , $comment->post_id)->with($response);//vuelvo al post
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }


    public function author($id)
    {
        $author = User::find($id);
        $posts = Post::where('user_id', $id)->orderBy('id', 'desc')->get();
        return view('frontend.index', ['posts' => $posts, 'author' => $author]);
    }



    function fallback()
    {
        $response = ['op' => 'fallback'];
        return redirect('/')->with($response);
    }

}
