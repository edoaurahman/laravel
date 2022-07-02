<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Available_Vaccines extends Model
{
    use HasFactory;
    protected $table = "available_vaccines";
    public $timestamps = false;
}
