<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookfavModel extends Model
{
    use HasFactory;
    protected $table='bookfav';
    public $timestamps=false;
}
