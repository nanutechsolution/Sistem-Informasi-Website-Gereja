<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PksSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'date',
        'time',
        'location',
        'leader_name',
        'description',
        'involved_members',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string',
        'is_active' => 'boolean',
    ];


    public function getStartDateTimeAttribute()
    {
        return Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
    }

    public function getEndDateTimeAttribute()
    {
        return $this->start_date_time->copy()->addHours(2);
    }
}