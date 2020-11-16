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

        $page = ucfirst($page);
        $data['page_title'] = $page;
        $data['project'] = $project->load('video', 'elements');

        if (strtolower($page) == 'player'){
            if ($project->setting->watch_access) {
                $this->authorize('watch', $project);
            }
        }

        if (strtolower($page) == 'embed') {

            if ($project->setting->embed_access) {
                $referer = $request->header('referer');
                $referer_scheme = parse_url($referer, PHP_URL_SCHEME);
                $referer_host = parse_url($referer, PHP_URL_HOST);
                $domain = $referer_scheme.'://'.$referer_host;

                if (! $project->canEmbed($domain) ) {
                    if (($domain != 'https://vunyx.com') || ($domain != 'https://www.vunyx.com')) {
                        abort(404);
                    }
                }
            }

            $data['height'] = $request->get('height');
            $data['width'] = $request->get('width');

        }
        
        return Inertia::render($page, $data);
    }
}
