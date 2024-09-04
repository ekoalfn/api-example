<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Http\Resources\PostsResource;
use App\Http\Resources\PostDetailResource;

class PostsController extends Controller
{
    public function index(){
        $posts = Posts::all();

        return PostsResource::collection($posts);
    }

    public function show($id){
        $posts = Posts::with('Writer:id,username')->findorFail($id);

        return new PostDetailResource($posts);
    }
}
