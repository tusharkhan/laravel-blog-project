<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::with(['category', 'user'])->orderBy('id', 'DESC')->paginate(20);

        return view('dashboard.info.index', compact('infos'));
    }

    public function destroy(string $id)
    {
        $info = Info::find($id);
        if ($info) {
            $info->delete();

            return back()->with('success', 'Info deleted!');
        }

        return back()->withErrors('Info not found!');
    }

    public function status($id)
    {
        $info = Info::find($id);
        if ($info) {
            $info->status = $info->status ? '0' : '1';
            $info->save();
            $alert = $info->status ? 'Info marked as reviewed!' : 'Info marked as pending!';

            return back()->with('success', $alert);
        }

        return back()->withErrors('Info not found!');
    }
}

