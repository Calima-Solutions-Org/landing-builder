<?php

namespace Calima\LandingBuilder\Controllers\GrapesJs;

use Calima\LandingBuilder\Controllers\Controller;
use Calima\LandingBuilder\Grapesjs\Block;
use Illuminate\Http\Request;

class JsController extends Controller
{
    public function __invoke(Request $request)
    {
        $blocks = Block::all();
        // dd($blocks);
        return response()->view('calima-builder::js.grapesjs', [
            'blocks' => $blocks,
        ], 200, [
            'Content-Type' => 'text/javascript',
        ]);
    }
}
