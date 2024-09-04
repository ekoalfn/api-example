<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Http\Resources\PostsResource;

class PostsController extends Controller
{
    public function index(){
        $posts = Posts::all();

        // return response()->json(['data' => $posts]);
        return PostsResource::collection($posts);
    }
}
