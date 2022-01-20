<?php
namespace App\Services;

use App\Models\Level;
use App\Models\Resource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File{
    public static function uploadFromBase64($fileString,$folders=[]) {
		$exploded = explode(',', $fileString);
		if (count($exploded) < 2) 
			return $fileString;
		$decoded = base64_decode($exploded[1]);
		if(str_contains($exploded[0],'mp4')){
			$extension = 'mp4';
		}
		elseif(str_contains($exploded[0],'mpeg')){
			$extension = 'mp3';
		}
		elseif(str_contains($exploded[0],'jpeg')){
			$extension = 'jpg';
		}
		elseif(str_contains($exploded[0],'png')){
			$extension = 'png';
		}
		
        if($extension != 'mp4' && $extension != 'mp3' && $extension != 'jpg' && $extension != 'png'){
            abort(403,"File extension must be one of these: mp4, mp3, jpg, png");
        }

		$fileName = Str::random().'.'.$extension;
        $folder = "";
        if(count($folders)){
            $folder1 = "";
            if(isset($folders['folder1'])){
                $level_id = $folders['folder1'];
                $level = Level::find($level_id);
                $folder1 = str_replace(" ","_",$level->name);
            }

            $folder2 = "";            
            if(isset($folders['folder2'])){
                $file_type = $folders['folder2'];
                switch($file_type){
                    case Resource::TYPE_VIDEO:
                        $folder2 = 'videos';
                        break;
                    case Resource::TYPE_AUDIO:
                        $folder2 = 'audios';
                        break;
                    case Resource::TYPE_IMAGE:
                        $folder2 = 'images';
                        break;
                    case Resource::TYPE_TEXT:{
                            abort(403,"Incorrect type chosen");
                        }
                        break;
                }
                if(
                    ($folder2 == 'videos' && $extension != 'mp4') || 
                    ($folder2 == 'audios' && $extension != 'mp3') || 
                    ($folder2 == 'images' && ($extension != 'jpg' && $extension != 'png'))
                ){
                    abort(403,"Incorrect type chosen");
                }
            }
            $folder = $folder1 . "/" . $folder2;
        }
        
        $filePath = "/".$folder."/".$fileName;
		Storage::put('/public/'.$filePath,$decoded);
		// file_put_contents(storage_path().$filePath, $decoded);
		return $filePath;
	}
}