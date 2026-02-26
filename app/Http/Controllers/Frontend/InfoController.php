<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->orderBy('title', 'ASC')->get();

        return view('frontend.info.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'links' => ['required', 'string', 'min:3'],
            'message' => ['required', 'string', 'min:3'],
        ];

        if (! Auth::check()) {
            $rules['name'] = ['required', 'string', 'min:3', 'max:100'];
            $rules['email'] = ['required', 'email:rfc', 'max:255'];
        }

        $validated = $request->validate($rules);

        if (! Auth::check() && User::where('email', $validated['email'])->first()) {
            return redirect()->route('frontend.info')->withErrors('An account with this email address already exists. Please login before submitting or use another email address!');
        }

        $data = [
            'category_id' => $validated['category_id'],
            'links' => $validated['links'],
            'message' => $validated['message'],
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            $data['name'] = $validated['name'];
            $data['email'] = $validated['email'];
        }

        Info::create($data);

        return redirect()->route('frontend.info')->with('success', 'Your information has been submitted successfully!');
    }
}

