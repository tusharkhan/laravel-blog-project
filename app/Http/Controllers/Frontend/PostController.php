<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index($slug)
    {
        // Get current locale to determine which slug column to search
        $locale = app()->getLocale();
        $slugColumn = $locale === 'bn' ? 'slug_bn' : 'slug';

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

            return view('frontend.post.index', compact('post', 'str'));
        }

        return abort(404);
    }
}
