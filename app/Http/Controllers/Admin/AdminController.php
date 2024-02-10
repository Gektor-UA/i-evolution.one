<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = Video::all();
//
//        foreach ($videos as $video) {
//            var_dump($video->video_url);
//        }

        return view('admin.main', ['videos' => $videos]);
    }
}
