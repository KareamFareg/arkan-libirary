<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contentModel extends Model
{
    use HasFactory;
    protected $table='content';
    public $timestamps=false;
}
