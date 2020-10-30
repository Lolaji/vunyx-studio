<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlayerController extends Controller
{
    public function index(Project $project)
    {
        $data['page_title'] = 'Player';
        $data['project'] = $project->load('video', 'elements');
        
        return Inertia::render('Player', $data);
    }
}
