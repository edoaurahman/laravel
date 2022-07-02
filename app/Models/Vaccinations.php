<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Spots;
use App\Models\Medical;

class Vaccinations extends Model
{
    use HasFactory;
    protected $table = 'vaccinations';
    public $timestamps = false;

    public function spot(){
        return $this->belongsTo(Spots::class, 'spot_id');
    }
    public function vaccinator(){
        return $this->belongsTo(Medical::class, 'doctor_id');
    }
    public function vaccine(){
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }
}
