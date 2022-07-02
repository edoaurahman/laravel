<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Available_Vaccines;
use App\Models\Vaccinations;

class Spots extends Model
{
    use HasFactory;
    protected $table = "spots";
    public $timestamps = false;

    public function available_vaccines(){
        return $this->hasOne(Available_Vaccines::class, 'spot_id');
    }

    public function vaccinations_count(){
        return $this->hasMany(Vaccinations::class, 'spot_id');
    }
}
