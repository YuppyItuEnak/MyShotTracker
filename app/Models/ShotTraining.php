<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShotTraining extends Model
{
    use HasFactory;

    protected $fillable = [ 'overall_shot_id', 'shotmade', 'attempt', 'location', 'accuracy'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function overallShot()
    {
        return $this->belongsTo(OverallShot::class, 'overall_shot_id');
    }
}
