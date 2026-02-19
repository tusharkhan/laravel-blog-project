<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class MediaController extends Controller
{
    public function index() {
        if (Auth::user()->role == 3) {
            $media = Media::with('files')->orderBy("id", "DESC")->paginate(10);
        } else {
            $media = User::find(Auth::id())->media()->with('files')->orderBy("id", "DESC")->paginate(10);
        }
        return view("dashboard.media.index", compact("media"));
    }

    public function create() {
        return view("dashboard.media.add");
    }

    public function store(Request $request) {
        $request->validate([
            "title"       => ["nullable", "string", "max:255"],
            "title_bn"    => ["nullable", "string", "max:255"],
            "description" => ["nullable", "string"],
            "description_bn" => ["nullable", "string"],
            "location"    => ["nullable", "string", "max:255"],
            "location_bn" => ["nullable", "string", "max:255"],
            "images"      => ["required", "array", "min:1"],
            "images.*"    => ["required", "image"],
        ]);

        $media = Media::create([
            "user_id"        => Auth::id(),
            "title"          => $request->title,
            "title_bn"       => $request->title_bn,
            "description"    => $request->description,
            "description_bn" => $request->description_bn,
            "location"       => $request->location,
            "location_bn"    => $request->location_bn,
        ]);

        foreach ($request->file("images") as $image) {
            $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
            $image->move(public_path("uploads/media"), $imageName);
            MediaFile::create([
                "media_id"  => $media->id,
                "file_name" => $imageName,
            ]);
        }

        // Set file_name to first image for backward compat
        $firstFile = $media->files()->first();
        if ($firstFile) {
            $media->update(["file_name" => $firstFile->file_name]);
        }

        return redirect()->route("dashboard.media.index")->with("success", "Media uploaded successfully!");
    }

    public function edit(string $id) {
        $media = Media::with('files')->find($id);
        if (!$media || !Gate::allows("update-media", $media)) {
            return redirect()->route("dashboard.media.index")->withErrors("Media not found or access denied!");
        }
        return view("dashboard.media.edit", compact("media"));
    }

    public function update(Request $request, string $id) {
        $media = Media::with('files')->find($id);
        if (!$media || !Gate::allows("update-media", $media)) {
            return redirect()->route("dashboard.media.index")->withErrors("Media not found or access denied!");
        }

        $request->validate([
            "title"          => ["nullable", "string", "max:255"],
            "title_bn"       => ["nullable", "string", "max:255"],
            "description"    => ["nullable", "string"],
            "description_bn" => ["nullable", "string"],
            "location"       => ["nullable", "string", "max:255"],
            "location_bn"    => ["nullable", "string", "max:255"],
            "images"         => ["nullable", "array"],
            "images.*"       => ["image"],
        ]);

        $media->update([
            "title"          => $request->title,
            "title_bn"       => $request->title_bn,
            "description"    => $request->description,
            "description_bn" => $request->description_bn,
            "location"       => $request->location,
            "location_bn"    => $request->location_bn,
        ]);

        if ($request->hasFile("images")) {
            foreach ($request->file("images") as $image) {
                $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
                $image->move(public_path("uploads/media"), $imageName);
                MediaFile::create([
                    "media_id"  => $media->id,
                    "file_name" => $imageName,
                ]);
            }
            // Update file_name to first image
            $firstFile = $media->files()->first();
            if ($firstFile) {
                $media->update(["file_name" => $firstFile->file_name]);
            }
        }

        return redirect()->route("dashboard.media.index")->with("success", "Media updated successfully!");
    }

    public function destroyFile(string $fileId) {
        $file = MediaFile::find($fileId);
        if ($file) {
            $media = $file->media;
            if (!Gate::allows("update-media", $media)) {
                return back()->withErrors("Access denied!");
            }
            if (File::exists(public_path("uploads/media/".$file->file_name))) {
                File::delete(public_path("uploads/media/".$file->file_name));
            }
            $file->delete();
            return back()->with("success", "Image deleted!");
        }
        return back()->withErrors("Image not found!");
    }

    public function destroy(string $id) {
        $media = Media::with('files')->find($id);
        if ($media && Gate::allows("update-media", $media)) {
            foreach ($media->files as $file) {
                if (File::exists(public_path("uploads/media/".$file->file_name))) {
                    File::delete(public_path("uploads/media/".$file->file_name));
                }
            }
            // Also delete old file_name if set directly
            if ($media->file_name && File::exists(public_path("uploads/media/".$media->file_name))) {
                File::delete(public_path("uploads/media/".$media->file_name));
            }
            $media->delete();
            return back()->with("success", "Media deleted!");
        }
        return back()->withErrors("Media not found!");
    }
}
