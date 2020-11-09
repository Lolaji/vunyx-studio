<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index($page='projects')
    {
        $filename = ucfirst($page);
        if (Str::contains($page, '-')) {
            $filename = str_replace(' ', '', ucwords(str_replace('-', ' ', $page)));
        }
        
        $data['page_title'] = ucfirst($page);
        $data['username'] = Auth::user()->name;
        if ($page == 'project') {
            $data['projects'] = Auth::user()->projects()->with('video')->get();
        }

        if  ($page == 'vx-videos') {
            $data['page_title'] = 'My Vunyx Videos';
            $data['vxVideos'] = Auth::user()->vx->videos;
        }

        return Inertia::render($filename, $data);
    }
}
