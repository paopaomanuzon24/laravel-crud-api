<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        //return view('posts.index', compact('posts'));
        return response()->json(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Post::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    // GET /apo/posts/{id}
    public function show(string $id)
    {
        $post = Post::find($id);
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

         $post = Post::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);


        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }

   /*  public function create(){
        return view('posts.create');
    } */

}
