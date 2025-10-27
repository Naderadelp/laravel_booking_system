<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'profile_photo_url',
    ];

    public function service(){
        return $this->belongsToMany(Service::class,'employe_service');
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function scheduleExclusions(){
        return $this->hasMany(ScheduleExclusion::class);
    }
}
