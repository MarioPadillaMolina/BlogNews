<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $array = [
            'postsOpen' => 'menu-open',
            'viewOpen' => 'active'
        ];
        
        // //paginación
        // $posts = Post::orderBy('id', 'desc')->paginate(10); //ordeno todos
        
        // return view('posts.index', ['posts' => $posts], $array);



        $posts = new Post();

        $order = ['id', 'title', 'date', 'time']; //AUTHOR??

        //campo de búsqueda
        $search = $request->input('search');

        // $user_names = User::select('users.name')
        // ->join('posts', 'users.id', '=', 'posts.user_id')
        // ->get();
        
        if($search != null) {
            $posts = $posts->where('title', 'like', '%' . $search . '%')
                                      //->orWhere('text', 'like', '%' . $search . '%')
                                      //->orWhere($user_names, 'like', '%' . $search . '%')
                                      ->orWhere('id', 'like', '%' . $search . '%')
                                      ->orWhere('date', 'like', '%' . $search . '%')
                                      ->orWhere('time', 'like', '%' . $search . '%');
        }

        $orderby = $request->input('orderby'); //el del request
        $orderby2 = $orderby;
        
        $sort = 'desc'; //valor de sort por defecto
        if($orderby != null) {
            if(isset($order[$orderby])) {
                //si encuentra un valor válido ordenable:
                $orderby = $order[$orderby];
            } else {
                $orderby = $order[0]; //ordena por id por defecto
            }
            if($request->input('sort') != null) {
                //si encuentra un valor de sort lo asigna a $sort
                $sort = $request->input('sort');
            }
            $posts = $posts->orderBy($orderby, $sort);
        }

        $paginationparameters = ['search' => $search, 'orderby' => $orderby2, 'sort' => $sort];
        $posts = $posts->orderBy('id', 'desc')->paginate(10)->appends($paginationparameters);
        // $enterprise = Enterprise::paginate($rpp)->appends(['rpp' => $rpp, 'search' => $search]);
        //para que aparezca en el formulario de búsqueda
        return view('posts.index', array_merge(['posts' => $posts], $paginationparameters));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = [
            'postsOpen' => 'menu-open',
            'createOpen' => 'active'
        ];
        return view('posts.create', $array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * App\Http\Requests\PostRequest
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        // $all = $request->validated();
        // No me sirve por la foto y el user_id que no son del Request
        // $post = new Post($all);

        // //el PostRequest ya viene validado
        $post = new Post();

        //del Request pido:
        $post->title = $request->input('title');
        $post->text = $request->input('text');
        $post->date = $request->input('date');
        $post->time = $request->input('time');

        //Auth coge los datos del usuario autenticado
        $post->user_id = auth()->user()->id;
        
        try {
            $result = $post->save();
        } catch (\exception $e) {
            $result = 0;
        }

        //imagen
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $extensions = ['.jpg', '.gif', '.png', '.jpeg'];
            foreach ($extensions as $extension) {
                if (file_exists('banner/' . $post->id . $extension)) {
                    unlink('banner/' . $post->id . $extension);
                }
            }
            $file = $request->file('image'); // $request->logo
            $target = 'banner/';
            $ext = \File::extension($file->getClientOriginalName());//coge el nombre del archivo
            $name = $post->id . "." . $ext; 
            //$name = date('YmdHis') . $file->getClientOriginalName();
            $file->move($target, $name);

            $post->image = $target . $name;
            $result = $post->save();
        }



        if ($post->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $post->id];
            return redirect()->route('posts.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //igual que el STORE pero sin crear un objeto nuevo, usamos el del parámetro

        //del Request pido:
        $post->title = $request->input('title');
        $post->text = $request->input('text');
        $post->date = $request->input('date');
        $post->time = $request->input('time');

        //Auth coge los datos del usuario autenticado
        $post->user_id = auth()->user()->id;

        //TODO guardar la imagen

        try {
            $result = $post->save();
        } catch (\exception $e) {
            $result = 0;
        }


        //imagen
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $extensions = ['.jpg', '.gif', '.png', '.jpeg'];
            foreach ($extensions as $extension) {
                if (file_exists('banner/' . $post->id . $extension)) {
                    unlink('banner/' . $post->id . $extension);
                }
            }
            $file = $request->file('image'); // $request->logo
            $target = 'banner/';
            $ext = \File::extension($file->getClientOriginalName());//coge el nombre del archivo
            $name = $post->id . "." . $ext; 
            //$name = date('YmdHis') . $file->getClientOriginalName();
            $file->move($target, $name);

            //guardo la ruta de la imagen en la BBDD
            $post->image = $target . $name;
            $result = $post->save();
        }


        if ($post->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $post->id];
            return redirect()->route('posts.index')->with($response);
        } else {
            return back()->withInput()->withErrors(['error' => 'Algo ha fallado']);
            //lo recojo con @errors
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $result = $post->delete();
        } catch (\Exception $ex) {
            $result = 0;
        }
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $post->id];
        return redirect()->route('posts.index')->with($response);
    }
}
