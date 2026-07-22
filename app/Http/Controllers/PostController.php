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
     * Retrieve the authenticated user's posts.
     *
     * Returns a paginated list of posts, optionally filtered by title using the
     * search query parameter. The number of items per page can be controlled with
     * the per_page query parameter.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = request()->user();
        //Si on veut retourner les infos de author
        //$post = $user->posts()->with("author")->paginate();
        //request()->input("per_page") recupere per_page de la query string
        // Par exemple http://127.0.0.1:8000/api/v1/posts?per_page=1
        if (request()->has('search') && ! empty(request()->input('search'))) {
            $search = request()->input('search');
            $post = $user->posts()->where('title', 'like', "%$search%")->paginate(request()->input('per_page'));
        } else {
            $post = $user->posts()->paginate(request()->input('per_page'));
        }

        return PostResource::collection($post);
    }

    /**
     * Create a new post for the authenticated user.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Display a specific post belonging to the authenticated user.
     *
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show(Post $post)
    {
        $user = request()->user();

        abort_if($user->id !== $post->author_id, 403, 'Accès non autorisé');

        return new PostResource($post);
    }

    /**
     * Update an existing post owned by the authenticated user.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function update(StorePostRequest $request, Post $post)
    {
        abort_if(Auth::id() !== $post->author_id, 403, 'Accès non autorisé');
        $data = $request->validated();
        $post->update($data);

        return new PostResource($post);
    }

    /**
     * Delete a post owned by the authenticated user.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function destroy(Post $post)
    {
        abort_if(Auth::id() !== $post->author_id, 403, 'Accès non autorisé');
        $post->delete();

        return response()->noContent();
    }
}
