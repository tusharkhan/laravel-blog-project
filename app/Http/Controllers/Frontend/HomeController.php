<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sitesettings = SiteSetting::first();

        // All active categories for the banner search dropdown
        $searchCategories = Category::where('status', true)->orderBy('title', 'ASC')->get();

        $searchQuery    = $request->q;
        $searchCategory = $request->category;

        if ($searchQuery) {
            // --- Search mode: return matched posts grouped by category ---
            $postsQuery = Post::with('category')
                ->whereStatus(true)
                ->where(function ($q) use ($searchQuery) {
                    $q->where('title',    'LIKE', "%{$searchQuery}%")
                      ->orWhere('title_bn', 'LIKE', "%{$searchQuery}%");
                });

            if ($searchCategory) {
                $postsQuery->where('category_id', $searchCategory);
            }

            // Fetch all matched posts (no pagination — we group by category)
            $allMatchedPosts = $postsQuery->orderBy('id', 'DESC')->get();

            // Group by category, preserving category model
            $searchPostsByCategory = $allMatchedPosts->groupBy('category_id')->map(function ($posts) {
                return [
                    'category' => $posts->first()->category,
                    'posts'    => $posts,
                ];
            })->values();

            $totalFound = $allMatchedPosts->count();

            $selectedCategory = $searchCategory
                ? $searchCategories->firstWhere('id', $searchCategory)
                : null;

            $categories = collect();

            return view('frontend.home.index', compact(
                'categories', 'sitesettings', 'searchCategories',
                'searchPostsByCategory', 'searchQuery', 'selectedCategory', 'totalFound'
            ));
        }

        // --- Normal mode: category-wise listing ---
        $categories = Category::where('status', true)
            ->withCount('posts')
            ->with(['posts' => function ($q) {
                $q->where('status', true)->orderBy('id', 'DESC');
            }])
            ->orderBy('id', 'DESC')
            ->get();

        $searchPostsByCategory = collect();
        $searchQuery           = null;
        $selectedCategory      = null;
        $totalFound            = 0;

        return view('frontend.home.index', compact(
            'categories', 'sitesettings', 'searchCategories',
            'searchPostsByCategory', 'searchQuery', 'selectedCategory', 'totalFound'
        ));
    }
}
