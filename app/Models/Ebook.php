<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ebook extends Model
{
    use HasFactory;
    use InteractsWithMedia;
    public function getBookAvatar($type="thumb"){
        if($this->image==null)
            return env('DEFAULT_IMAGE_AVATAR');
        else
            return env("STORAGE_URL").'/'.\MainHelper::get_conversion($this->image,$type);
    }
    
    protected $table='ebooks';
    // public $timestamps=false;
}
