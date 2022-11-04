<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Post;
use DB;
use Orhanerday\OpenAi\OpenAi;
use RuliLG\StableDiffusion\StableDiffusion;
use RuliLG\StableDiffusion\Prompt;
use RuliLG\StableDiffusion\Models\StableDiffusionResult;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show','summarize','extract','generateimage']]);
    }

    public function index()
    {
        //return Post::where('title','Post Two')->get();
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = DB::select('SELECT * FROM posts');
        $posts = Post::orderBy('created_at','desc')->paginate(3);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;

        // Handle File Upload
        if ($request->file('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            $fileNameToStore= "/storage/cover_images/".$fileNameToStore;
        } else {
            $summary = $post->toSummarize();
            $fileNameToStore = $post->createCover_Image()[0];
        }

        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //Check for correct user
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        return view('posts.edit')->with('post',$post);
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
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if ($request->file('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            $fileNameToStore= '/storage/cover_images/'.$fileNameToStore;

        }

        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        if ($request->file('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        if($post->cover_image!='noimage.jpg'){
            //Delete The image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }

    public function summarize($id){
        $post = Post::find($id);
        $summary = $post->toSummarize();
        return view('/posts/summary',['summary'=>$summary,'post'=>$post]);
    }

    public function extract($id){
        $post = Post::find($id);
        $ideas = $post->toExtract();
        return view('/posts/ideas',['ideas'=>$ideas, 'post'=>$post]);
    }

    public function generateimage($id){
        $post = Post::find($id);;
        $url = $post->createCover_Image()[0];
        return view('/posts/generateimage',['post'=>$post, 'url'=>$url]);
    }
}
