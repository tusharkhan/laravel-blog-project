<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index($slug) {
        $post = Post::with(["category", "user", "tags", "links", "comments.user", "comments.replies.user"])->with("comments.replies", function($q) {
            $q->where("status", true);
        })->with("comments", function($q) {
            $q->where("status", true)->where("parent_id", null);
        })->withCount(["tags", "links", "comments" => function($q) {
            $q->where("status", true);
        }])->where("status", true)->where("slug", $slug)->first();
        if ($post) {
            $post->views += 1;
            $post->save();
            $str = Str::class;
            return view("frontend.post.index", compact("post", "str"));
        }
        return abort(404);
    }
}
