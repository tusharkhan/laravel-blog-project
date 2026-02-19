<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug) {
        $slug_column = app()->getLocale() == "en" ? "slug" : "slug_bn";
        $category = Category::where($slug_column, $slug)->where("status", true)->first();
        if ($category) {
            $str = Str::class;
            $posts = $category->posts()->with(["category", "user"])->where("status", true)->orderBy("id", "DESC")->paginate(10);
            return view("frontend.category.index", compact("category", "posts", "str"));
        }
        return abort(404);
    }
}
