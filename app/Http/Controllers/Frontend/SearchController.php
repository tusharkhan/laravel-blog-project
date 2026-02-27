<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->q) {
            $query = $request->q;
            $categoryId = $request->category;

            $postsQuery = Post::with('category')
                ->whereStatus(true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('title_bn', 'LIKE', "%{$query}%");
                });

            if ($categoryId) {
                $postsQuery->where('category_id', $categoryId);
            }

            $posts = $postsQuery->orderBy('id', 'DESC')->paginate(10);
            $searchCategories = Category::where('status', true)->orderBy('title', 'ASC')->get();
            $selectedCategory = $categoryId;

            return view('frontend.search.index', compact('posts', 'query', 'searchCategories', 'selectedCategory'));
        }

        return redirect()->route('frontend.home');
    }
}
