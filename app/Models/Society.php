<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regional;

class Society extends Model
{
    use HasFactory;
    protected $table = "societies";

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public $timestamps = false;
}
