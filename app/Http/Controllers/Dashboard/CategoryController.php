<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount(["posts" => function($q) {
            $q->withTrashed();
        }])->orderBy("title", "ASC")->paginate(20);
        return view("dashboard.category.index", compact("categories"));
    }

    public function create() {
        return view("dashboard.category.add");
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "title" => ["required", "string", "max:150"],
            "title_bn" => ["nullable", "string", "max:150"],
            "slug" => ["required", "max:150", "unique:categories,slug"],
            "slug_bn" => ["nullable", "max:150"],
            "description" => ["nullable", "string"],
            "description_bn" => ["nullable", "string"],
            "status" => ["required", Rule::in(["0", "1"])],
        ]);
        Category::create([
            "title" => $validated["title"],
            "title_bn" => Arr::has($validated, "title_bn") ? $validated["title_bn"] : null,
            "slug" => $validated["slug"],
            "slug_bn" => Arr::has($validated, "slug_bn") ? $validated["slug_bn"] : null,
            "description" => Arr::has($validated, "description") ? $validated["description"] : null,
            "description_bn" => Arr::has($validated, "description_bn") ? $validated["description_bn"] : null,
            "status" => $validated["status"],
        ]);
        return redirect()->route("dashboard.categories.index")->with("success", "Category created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {

    }

    public function edit(string $id) {
        $category = Category::find($id);
        if ($category) {
            return view("dashboard.category.edit", compact("category"));
        }
        return back()->withErrors("Category not exists!");
    }

    public function update(Request $request, string $id) {
        $category = Category::find($id);
        if ($category) {
            $validated = $request->validate([
                "title" => ["required", "string", "max:150"],
                "title_bn" => ["nullable", "string", "max:150"],
                "slug" => ["required", "max:150", Rule::unique("categories", "slug")->ignore($id)],
                "slug_bn" => ["nullable", "max:150"],
                "description" => ["nullable", "string"],
                "description_bn" => ["nullable", "string"],
                "status" => ["required", Rule::in(["0", "1"])],
            ]);
            $category->title = $validated["title"];
            $category->title_bn = Arr::has($validated, "title_bn") ? $validated["title_bn"] : null;
            $category->slug = $validated["slug"];
            $category->slug_bn = Arr::has($validated, "slug_bn") ? $validated["slug_bn"] : null;
            $category->description = Arr::has($validated, "description") ? $validated["description"] : null;
            $category->description_bn = Arr::has($validated, "description_bn") ? $validated["description_bn"] : null;
            $category->status = $validated["status"];
            $category->save();
            return redirect()->route("dashboard.categories.index")->with("success", "Category updated!");
        }
        return back()->withErrors("Category not exists!");
    }

    public function destroy(string $id) {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return back()->with("success", "Category deleted!");
        }
        return back()->withErrors("Category not exists!");
    }

    public function restore($id) {
        $category = Category::onlyTrashed()->find($id);
        if ($category) {
            $category->restore();
            return back()->with("success", "Category restored!");
        }
        return back()->withErrors("Category not exists!");
    }

    public function status($id) {
        $category = Category::find($id);
        if ($category) {
            $category->status = $category->status ? "0" : "1";
            $category->save();
            $alert = $category->status ? "Category Activated!" : "Category Inactivated!";
            return back()->with("success", $alert);
        }
        return back()->withErrors("Category not exists!");
    }

    public function trashed() {
        $categories = Category::onlyTrashed()->withCount(["posts" => function($q) {
            $q->withTrashed();
        }])->orderBy("title", "ASC")->paginate(20);
        return view("dashboard.category.trashed", compact("categories"));
    }

    public function delete($id) {
        $category = Category::onlyTrashed()->find($id);
        if ($category) {
            $category->posts()->forceDelete();
            $category->forceDelete();
            return back()->with("success", "Category deleted!");
        }
        return back()->withErrors("Category not exists!");
    }
}
