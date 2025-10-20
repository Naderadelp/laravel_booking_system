<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Bookings\ScheduleAvailability;
use App\Models\Service;

Route::get('/', function ()
    {
        $employee = Employee::find(1);

        $services = Service::find(1);

        $availability = (new ScheduleAvailability($employee, $services))
            ->forPeriod(
                now()->startOfDay(),
                now()->addMonth()->endOfDay()
            );
    }
);
