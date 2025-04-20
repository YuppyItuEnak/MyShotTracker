<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallShot extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'totalmade', 'totalattempt', 'totalaccuracy', 'date'];

    public function shotTrainings()
    {
        return $this->hasMany(ShotTraining::class, 'overall_shot_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
