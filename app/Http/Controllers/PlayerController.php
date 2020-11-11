<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlayerController extends Controller
{
    public function index(Request $request, $page='player', Project $project)
    {
        if (($page != "embed") && ($page != 'player')) {
            abort(404);
        }

        if ($page == 'embed') {
            $data['height'] = $request->get('height');
            $data['width'] = $request->get('width');

        }

        $page = ucfirst($page);
        $data['page_title'] = $page;
        $data['project'] = $project->load('video', 'elements');
        
        return Inertia::render($page, $data);
    }
}
