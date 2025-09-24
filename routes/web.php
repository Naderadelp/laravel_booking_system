<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Bookings\ScheduleAvailability;

Route::get('/', function () {
    $availability = (new ScheduleAvailability())->forPeriod(now(), now()->addMonth());

});
