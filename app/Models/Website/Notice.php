<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website;

use App\Models\Base\ParentModel;
use Illuminate\Support\Str;

class Notice extends ParentModel
{
    protected $guarded = ['id'];

    protected $logName = 'Notice';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = Notice::createSlug($url->title);
        });
    }

    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = Notice::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug.$count;
        }

        return $slug;
    }

    // file image push
    public function getFileAttribute($value)
    {
        if (! empty($value)) {
            return url('').'/public/storage/'.$value;
        }

        return null;
    }

    // date format
    public function setNoticeDateAttribute($value)
    {
        $dateArray = explode(' ', $value);
        $day = $dateArray[0];
        $month = date_parse($value);
        $year = $dateArray[2];
        $date = $year.'-'.$month['month'].'-'.$day;
        $this->attributes['notice_date'] = $date;
    }

    public function getNoticeDateAttribute($value)
    {
        return date('d M, Y', strtotime($value));
    }

    public function setNoticeEndAttribute($value)
    {
        if (! empty($value)) {
            $dateArray = explode(' ', $value);
            $day = $dateArray[0];
            $month = date_parse($value);
            $year = $dateArray[2];
            $date = $year.'-'.$month['month'].'-'.$day;
            $this->attributes['notice_date'] = $date;
        }
    }

    public function getNoticeEndAttribute($value)
    {
        if (@! empty($value)) {
            return date('d M, Y', strtotime($value));
        }

    }
}
