<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active categories with their recent posts and total post count
        $categories = Category::where('status', true)
            ->withCount('posts')
            ->with(['posts' => function ($query) {
                $query->where('status', true)
                    ->orderBy('id', 'DESC')
                    ->get();
            }])
            ->orderBy('id', 'DESC')
            ->get();

        $sitesettings = SiteSetting::first();

        // All active categories for the banner search dropdown
        $searchCategories = Category::where('status', true)->orderBy('title', 'ASC')->get();

        return view('frontend.home.index', compact('categories', 'sitesettings', 'searchCategories'));
    }
}
