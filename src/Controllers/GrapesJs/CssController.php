<?php

namespace Calima\LandingBuilder\Controllers\GrapesJs;

use Calima\LandingBuilder\Controllers\Controller;
use Illuminate\Http\Request;

class CssController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->view('calima-builder::css.grapescss', [], 200, [
            'Content-Type' => 'text/css',
        ]);
    }
}
