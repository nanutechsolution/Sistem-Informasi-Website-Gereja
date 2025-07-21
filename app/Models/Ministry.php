<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function ministryMembers(): HasMany
    {
        return $this->hasMany(MinistryMember::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'ministry_members')
            ->withPivot('role', 'joined_date');
    }
}
