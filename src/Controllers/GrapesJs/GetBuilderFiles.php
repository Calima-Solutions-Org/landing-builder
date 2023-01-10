<?php

namespace Calima\LandingBuilder\Controllers\GrapesJs;

use Calima\LandingBuilder\Controllers\Controller;
use Calima\LandingBuilder\Models\BuilderFile;

class GetBuilderFiles extends Controller
{
    public function __invoke()
    {
        return BuilderFile::select('type', 'src', 'height', 'width', 'name')
                ->latest()
                ->get();
    }
}
