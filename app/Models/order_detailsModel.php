<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detailsModel extends Model
{
    use HasFactory;
    protected $table='order_details';
    public $timestamps=false;
}
