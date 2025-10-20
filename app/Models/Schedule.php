<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_at',
        'ends_at',
        'monday_start_at',
        'monday_ends_at',
        'tuesday_start_at',
        'tuesday_ends_at',
        'wednesday_start_at',
        'wednesday_ends_at',
        'thursday_start_at',
        'thursday_ends_at',
        'sunday_start_at',
        'sunday_ends_at',
    ];

    protected $casts = [
        'start_at' => 'date',
        'ends_at'  => 'date',
    ];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function getWorkingHours(Carbon $day)
    {
        $hours = array_filter([
            $this->{strtolower($day->format('l')) . '_start_at'},
            $this->{strtolower($day->format('l')) . '_ends_at'},
        ]);

        return empty($hours) ? null : $hours;
    }

}
