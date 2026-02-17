<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index() {
        // Get all active categories with their recent posts and total post count
        $categories = Category::where("status", true)
            ->withCount('posts')
            ->with(['posts' => function($query) {
                $query->where("status", true)
                    ->orderBy("id", "DESC")
                    ->get();
            }])
            ->orderBy("id", "DESC")
            ->get();

        return view("frontend.home.index", compact("categories"));
    }
}
