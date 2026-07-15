<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        //Si on veut retourner les infos de author
        //$post = $user->posts()->with("author")->paginate();
        $post = $user->posts()->paginate();
        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $data['author_id'] = $user->id;
        $post = Post::create($data);
        return response()->json(new PostResource($post), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = request()->user();

        abort_if($user->id !== $post->author_id, 403, 'Accès non autorisé');

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        abort_if(Auth::id() !== $post->author_id, 403, 'Accès non autorisé');
        $data = $request->validated();
        $post->update($data);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if(Auth::id() !== $post->author_id, 403, 'Accès non autorisé');
        $post->delete();
        return response()->noContent();
    }
}
