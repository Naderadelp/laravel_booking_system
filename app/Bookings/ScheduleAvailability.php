<?php

namespace App\Bookings;

use App\Models\Employee;
use App\Models\ScheduleExclusion;
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

  public function forPeriod(Carbon $startAt, Carbon $endAt)
  {
      collect(CarbonPeriod::create($startAt , $endAt)->days())
              ->each(function($day)  {
                  $this->addAvailabilityFromSchedule($day);

                  $this->employee->scheduleExclusions()->each(function(ScheduleExclusion $exclusion){
                    $this->subtractScheduleExclusion($exclusion);
                  });
              });

              $this->excludeTinePassedToday();

              foreach($this->periods as $period){
                  dump($period->asString());
                  dump($period->start()->format('l'));
                  dump($period->end()->format('l'));
                  dump('===============================================');
              }
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

  protected function subtractScheduleExclusion(ScheduleExclusion $exclusion){
    $this->periods = $this->periods->subtract(
      Period::make(
        $exclusion->start_at,
        $exclusion->ends_at,
        Precision::MINUTE(),
        Boundaries::EXCLUDE_END(),
      )
      );
  }

  protected function excludeTinePassedToday()
  {
    $this->periods = $this->periods->subtract(
      Period::make(
        now()->startOfDay(),
        now()->endOfHour(),
        Precision::MINUTE(),
        Boundaries::EXCLUDE_START(),
      )
    );
  }

}
