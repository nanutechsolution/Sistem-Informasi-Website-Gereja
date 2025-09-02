<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'head_member_id',
        'family_name'
    ];

    public function headMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'head_member_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'family_members')
            ->withPivot('relationship');
    }


    public function pksSchedules()
    {
        return $this->hasMany(PksSchedule::class);
    }
}