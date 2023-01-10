<?php

namespace Calima\LandingBuilder\Controllers\GrapesJs;

use Calima\LandingBuilder\Controllers\Controller;
use Calima\LandingBuilder\Models\BuilderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreBuilderFiles extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|mimetypes:image/*,video/*,audio/*,application/pdf',
        ]);

        $data = [];
        foreach ($validated['files'] as $file) {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = config('pagebuilder.uploads.path') . '/' . $fileName;
            // get type of file, in "image", "video", "audio" or "file"
            $type = explode('/', $file->getMimeType())[0];
            [$width, $height] = getimagesize($file->getPathName()); // width will be false if it's not an image
            Storage::putFileAs(config('pagebuilder.uploads.path'), $file, $fileName, 'public');
            $data[] = [
                'type' => $type,
                'src' => $path,
                'height' => $width ? $height : null,
                'width' => $width ? $width : null,
                'name' => $file->getClientOriginalName(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        BuilderFile::insert($data);

        return response()->json([
            'data' => (new GetBuilderFiles())(),
        ]);
    }
}
