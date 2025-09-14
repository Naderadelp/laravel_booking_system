<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $employee = Employee::find(1);
    dd($employee->service);
});
