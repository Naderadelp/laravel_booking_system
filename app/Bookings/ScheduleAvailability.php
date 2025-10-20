<?php

namespace App\Bookings;

use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

class ScheduleAvailability
{
  protected PeriodCollection $periods;

  protected $employee;

  protected $services;

  public function __construct(Employee $employee, Service $services){
    $this->periods = new PeriodCollection();
    $this->employee = $employee;
    $this->services = $services;
  }

  public function forPeriod(Carbon $startAt, Carbon $endAt){
    collect(CarbonPeriod::create($startAt , $endAt)->days())
            ->each(function($day)  {
                $this->addAvailabilityFromSchedule($day);
            });

            dd($this->periods);


















      // $this->periods = $this->periods->add(
      //   Period::make(
      //     now()->startOfDay(),
      //     now()->addDay()->endOfDay(),
      //     Precision::MINUTE(),
      //     Boundaries::EXCLUDE_START()
      //     ));
      // $this->periods = $this->periods->subtract(
      //   Period::make(
      //     Carbon::createFromTimeString('1:00:00'),
      //     Carbon::createFromTimeString('1:30:00'),
      //     Precision::MINUTE(),
      //     Boundaries::EXCLUDE_END()
      //   )
      //   );
  }

  protected function  addAvailabilityFromSchedule(Carbon $day)
  {
      $schedule = $this->employee->schedules()->where('start_at', '<=' , $day)->where('ends_at', '>=', $day)->first();

      if(!$schedule)
       {
        return;
      }

      $workinhHourrs = [$startAt, $endAt] = $schedule->getWorkingHours($day);

      if(!$workinhHourrs){
        return;
      }

      $this->periods = $this->periods->add(
        Period::make(
          $day->copy()->setTimeFromTimeString($startAt),
          $day->copy()->setTimeFromTimeString($endAt)->subMinutes($this->services->duration),
          Precision::MINUTE(),
        )
      );
  }

}
