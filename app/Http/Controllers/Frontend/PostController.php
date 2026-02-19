<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index($slug)
    {
        $slugColumn ='slug';

        // Try to find post by the appropriate slug column
        $post = Post::with(['category', 'user', 'tags', 'links', 'comments.user', 'comments.replies.user'])
            ->with('comments.replies', function ($q) {
                $q->where('status', true);
            })
            ->with('comments', function ($q) {
                $q->where('status', true)->where('parent_id', null);
            })
            ->withCount(['tags', 'links', 'comments' => function ($q) {
                $q->where('status', true);
            }])
            ->where('status', true)
            ->where(function ($query) use ($slug, $slugColumn) {
                $query->where($slugColumn, $slug)
                    ->orWhere('slug', $slug); // Fallback to English slug
            })
            ->first();

        if ($post) {
            $post->views += 1;
            $post->save();
            $str = Str::class;

            $categoryPosts = $post->category->posts()->where('id', '!=', $post->id)->orderBy('id', 'DESC')->paginate(10);

            return view('frontend.post.index', compact('post', 'str', 'categoryPosts'));
        }

        return abort(404);
    }
}
