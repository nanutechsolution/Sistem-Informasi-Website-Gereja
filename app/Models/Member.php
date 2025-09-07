<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'nik',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'blood_type',
        'address',
        'city',
        'province',
        'postal_code',
        'phone_number',
        'email',
        'baptism_date',
        'sidi_date',
        'marital_status',
        'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'baptism_date' => 'date',
        'sidi_date' => 'date',
        'join_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class, 'family_members')
            ->withPivot('relationship');
    }

    public function headOfFamily(): HasMany
    {
        return $this->hasMany(Family::class, 'head_member_id');
    }

    public function ministryMembers(): HasMany
    {
        return $this->hasMany(MinistryMember::class);
    }

    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /**
     * Get the auction transactions for the member.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(AuctionTransaction::class);
    }
}