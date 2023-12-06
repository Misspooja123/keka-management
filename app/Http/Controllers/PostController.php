<?php

namespace App\Http\Controllers;

use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessImage;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $userpost = $this->postRepository->all();
        return view('home', compact('userpost'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $post = $this->postRepository->create($data);


        return response()->json(['post' => $post], 201);
    }

    public function toggleLike(Request $request)
    {
        $postId = $request->input('post_id');
        $userId = Auth::user()->id;

        $isLiked = $this->postRepository->toggleLike($postId, $userId);

        return response()->json(['is_liked' => $isLiked]);
    }


}
