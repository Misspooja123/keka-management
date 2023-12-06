<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\Like;
use App\Jobs\ProcessImage;
use App\Events\ImageUploaded;


class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with('user')->get();
        $post = Post::all();
        $like_post = Like::where('user_id', $post->id)->get();
        return $like_post;
    }

    public function create(array $data)
    {
        $post = new Post;
        $post->text = $data['text'] ?? ' ';
        $post->user_id = auth()->id();

        if (isset($data['image'])) {
            $image = $data['image'];

            $filename = time() . '.' . $image->extension();

            $path = public_path() . '/assets/Post';
            $image->move($path, $filename);
            $post->image = $filename;
        }

        $post->save();

        // ProcessImage::dispatch($post);
        event(new ImageUploaded($image));

        return $post;
    }

    public function toggleLike($postId, $userId)
    {

        $existingLike = Like::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {

            $existingLike->delete();
            return false;
        } else {

            Like::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            return true;
        }
    }
}
