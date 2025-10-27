<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleExclusion extends Model
{
    protected $fillable = [
        'employee_id',
        'start_at',
        'ends_at',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    
}
