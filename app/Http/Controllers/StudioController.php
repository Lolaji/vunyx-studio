<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StudioController extends Controller
{
    public function index (Request $request) 
    {
        $data['page_title'] = 'Studio';

        return Inertia::render('studio/Index', $data);
    }
}
