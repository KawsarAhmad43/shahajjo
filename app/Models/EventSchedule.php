<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\ParentModel;

class EventSchedule extends ParentModel
{
    protected $guarded = ['id'];

    protected $logName = 'EventSchedule';

    public function setScheduleDateAttribute($value)
    {
        $dateArray = explode(' ', $value);
        $day = $dateArray[0];
        $month = date_parse($value);
        $year = $dateArray[2];
        $date = $year.'-'.$month['month'].'-'.$day;
        $this->attributes['schedule_date'] = $date;
    }

    public function getScheduleDateAttribute($value)
    {
        return date('d M, Y', strtotime($value));
    }
}
