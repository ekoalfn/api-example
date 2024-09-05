<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;

class PostsController extends Controller
{
    public function index(){
        $posts = Posts::all();

        return PostsResource::collection($posts);
    }

    public function show($id){
        $posts = Posts::with(['Writer:id,username', 'Comment'])->findorFail($id);

        return new PostDetailResource($posts->loadMissing(['writer:id,username', 'comment:id,post_id,comments_content,user_id']));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $request['author'] = Auth::user()->id;

        $posts = Posts::create($request->all());
        return new PostDetailResource($posts);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $post = Posts::findOrFail($id);
        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id){
        $post = Posts::findOrFail($id);
        $post->delete();

        return response()->json($post); 
    }
}
