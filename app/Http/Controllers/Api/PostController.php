<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        if(!$posts){
            return response()->json([
              'message'=> 'Not found'
            ],404);
        }
        return response()->json([
            'message'=>'Posts retrieved successfully',
           'data'=>PostResource::collection($posts),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json([
           'message'=>'Post created successfully',
           'data'=>$post,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'message'=> 'Not found'
            ],404);
        }
        return response()->json([
            'message'=>'Post retrieved successfully',
           'data'=>$post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        if(!$post){
            return response()->json([
               'message'=> 'Not found'
            ],404);
        }
        return response()->json([
           'message'=>'Post updated successfully',
           'data'=> $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if(!$post){
            return response()->json([
               'message'=> 'Not found'
            ],404);
        }
        $post->delete();
        return response()->json([
           'message'=>'Post soft deleted successfully',
        ]);
    }
}
