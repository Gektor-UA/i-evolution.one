<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function uploadVideo(Request $request)
    {

        $request->validate([
            'video' => 'required_without:youtubeLink|mimes:mp4,mov,avi,wmv,flv',
            'youtubeLink' => 'required_without:video|url',
            'user_id' => 'required|integer',
        ]);

        if ($request->hasFile('video')) {
            // Завантаження відео
            $videoPath = $request->file('video')->store('videos', 'public');
            // Збереження відео у базі даних
            Video::create([
                'user_id' => $request->user_id,
                'file_path' => $videoPath,
                'is_sent' => true,
            ]);
        }

        if ($request->filled('youtubeLink')) {
            // Збереження посилання на YouTube
            Video::create([
                'user_id' => $request->user_id,
                'video_url' => $request->input('youtubeLink'),
                'is_sent' => true,
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

    public function approveVideo($id)
    {
        Video::findOrFail($id)->update(['is_approved' => 1]);

        return redirect()->back()->with('success', 'Відео підтверджено');
    }

    public function rejectVideo($id)
    {
        Video::findOrFail($id)->update(['is_approved' => 0]);

        return redirect()->back()->with('success', 'Відео відхилено');
    }
}
