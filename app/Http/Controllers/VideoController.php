<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required_without:youtubeLink|mimes:mp4,mov,avi,wmv,flv',
            'youtubeLink' => 'required_without:video|url',
        ]);

        if ($request->hasFile('video')) {
            // Завантаження відео
            $videoPath = $request->file('video')->store('videos', 'public');
            // Збереження відео у базі даних
            Video::create([
                'file_path' => $videoPath,
                'is_sent' => true,
                'is_approved' => false,
            ]);
        }

        if ($request->filled('youtubeLink')) {
            // Збереження посилання на YouTube
            Video::create([
                'video_url' => $request->input('youtubeLink'),
                'is_sent' => true,
                'is_approved' => false,
            ]);
        }

        return redirect()->back();
    }

    public function downloadVideo($id)
    {
        $video = Video::find($id);
        if (!$video) {
            abort(404);
        }

        $filePath = storage_path('app/public/'.$video->file_path);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $video->file_name);
    }
}
