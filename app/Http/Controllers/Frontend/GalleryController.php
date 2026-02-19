<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('files')->orderBy('id', 'DESC');

        // Filter by title (searches both English and Bangla)
        if ($request->filled('title')) {
            $search = $request->title;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('title_bn', 'LIKE', "%{$search}%");
            });
        }

        // Filter by date (YYYY-MM format from month picker or YYYY-MM-DD)
        if ($request->filled('date')) {
            $date = $request->date;
            // Support both YYYY-MM and YYYY-MM-DD
            if (strlen($date) === 7) {
                $query->whereYear('created_at', substr($date, 0, 4))
                      ->whereMonth('created_at', substr($date, 5, 2));
            } else {
                $query->whereDate('created_at', $date);
            }
        }

        $mediaItems = $query->paginate(6)->withQueryString();

        // Build distinct year-month list for the date dropdown
        $dates = Media::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_val, DATE_FORMAT(created_at, '%M %Y') as month_label")
            ->orderByRaw("created_at DESC")
            ->distinct()
            ->pluck('month_label', 'month_val');

        return view('frontend.gallery.index', compact('mediaItems', 'dates'));
    }
}

