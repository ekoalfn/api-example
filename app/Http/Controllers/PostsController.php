<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;

class PostsController extends Controller
{
    public function index(){
        $posts = Posts::all();

        return PostDetailResource::collection($posts->loadMissing(['writer:id,username', 'comment:id,post_id,comments_content,user_id']));
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

        if($request->file){
            $filename = $this->generateRandomString();
            $extension = $request->file->extension();
            $image = $filename.'.'.$extension;

            Storage::putFileAs('image', $request->file, $image);
            $request['image'] = $image;
        }

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

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
}
