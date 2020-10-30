<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudioController extends Controller
{
    public function index (Request $request, Project $project) 
    {
        $data['page_title'] = 'Studio';

        $data['project'] = $project->load('video', 'elements');

        // dd($data['project']);

        return Inertia::render('studio/Index', $data);
    }
}
