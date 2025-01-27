<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\Video;

class VideoController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function videos(){
        $Cours = Cours::get();
        $respons = array();
        foreach ($Cours as $key => $value) {
            $respons[$key]['cours_id'] = $value['id'];
            $respons[$key]['cours_name'] = $value['cours_name'];
            $respons[$key]['count'] = count(Video::where('cours_name',$value['cours_name'])->get());
        }
        return view('SuperAdmin.video.videos',compact('respons'));
    }
    public function video($name){
        $videos = Video::where('cours_name',$name)->get();
        return view('SuperAdmin.video.videos_show',compact('videos','name'));
    }
    public function create(Request $request){
        $validate = $request->validate([
            'cours_name' => ['required', 'string', 'max:255'],
            'sort_numbr' => ['required', 'string', 'max:255'],
            'lessen_name' => ['required', 'string', 'max:255'],
            'video_url' => ['required', 'string', 'max:255'],
        ]);
        Video::create([
            'cours_name' => $request->cours_name,
            'sort_numbr' => $request->sort_numbr,
            'lessen_name' => $request->lessen_name,
            'video_url' => $request->video_url,
        ]);
        return redirect()->back();
    }
    public function delete(Request $request){
        $Video = Video::find($request->id);
        $Video->delete();
        return redirect()->back();
    }
}
