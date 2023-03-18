<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Debugbar;
use FFMpeg;

class Video{
    public $name;
    public $file;
    public $thumbnail;

}

class HomeController extends Controller
{

    public $storagePathNSFW ="public/NSFW";
    public $storagePathSFW="public/SFW";


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    private function getVideoTitle($movie){
            Debugbar::warning($movie);
            //remove storage
            $name =basename($movie);

            //remove [12314124] and [xsad-asd] like stuff
            $pattern = "/ \[[\w-]+\]/";
            $name = preg_replace($pattern,"",$name);
            
            //remove extension
            $pattern = "/.mp4$/";
            $name = preg_replace($pattern,"",$name);

            return $name;
    }

    public function root(Request $request){
        $mode = $request->input("mode");
        if ($mode == null){
            $mode = "sfw";
        }
        $thumbnails=[];
        $videos=[];
        
        $storagePath=null;

        if (strtolower($mode)=="nsfw"){
            $storagePath = $this->storagePathNSFW;
        }else{
            $storagePath = $this->storagePathSFW;
        }

        foreach(Storage::files($storagePath) as $movie){
        
            $splited =explode(".",$movie);

            $ext =$splited[count($splited)-1];

            if (!in_array($ext,["mp4"]) ){
                continue;
            }
            $video = new Video();
            
            $video->name=$this->getVideoTitle($movie);
            $video->file=Storage::url($movie);

            $thumbnail="";
            foreach( $splited as $ind=>$item){

                if ($ind !=count($splited)-1){
                    $thumbnail=$thumbnail.$item.".";
                }else{
                    $thumbnail=$thumbnail."jpg";
                }
            }


            $video->thumbnail=Storage::url($thumbnail);
            array_push($videos,$video);

        
            if(Storage::disk('local')->exists($thumbnail)){
                // echo '<img src="'.Storage::url($thumbnail).'">';
                array_push($thumbnails,Storage::url($thumbnail));
                continue;
            }
            
            createThumbnail($movie);
        }
        
        return view("home",["videos"=>$videos]);
    }

    private function createThumbnail($videoFilePath){
        $thumbnailFrameSec = 10;

        $ffmpeg = FFMpeg::fromDisk('local');
        $video = $ffmpeg->open($movvideoFilePathie);
        $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($thumbnailFrameSec));
        $frame->export()->toDisk("local")->save($thumbnail);
    }

    public function video(Request $request){
        $link=$request->query("link");
        $title= $this->getVideoTitle($link);

        return view("video",["videoLink"=>basename($link),"title"=>$title]);
    }
}
