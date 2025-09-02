<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PksSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'leader_id',
        'date',
        'time',
        'scripture',
        'involved_members',
        'day_of_week'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string',
        'is_active' => 'boolean',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }


    public function getStartDateTimeAttribute()
    {
        return Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
    }

    public function getEndDateTimeAttribute()
    {
        return $this->start_date_time->copy()->addHours(2);
    }


    public function members()
    {
        return $this->belongsToMany(Member::class, 'pks_schedule_member', 'pks_schedule_id', 'member_id');
    }
}