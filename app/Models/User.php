<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    // Relasi ke tabel 'notifications' kustom kita
    public function notifications(): HasMany // Ini semua notifikasi
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotificationsCustom(): HasMany // <-- Ini untuk notifikasi yang belum dibaca dari tabel kustom kita
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }
    public function recordedIncomes(): HasMany
    {
        return $this->hasMany(Income::class, 'recorded_by_user_id');
    }

    public function recordedExpenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'recorded_by_user_id');
    }


    // public function getProfilePhotoUrlAttribute()
    // {
    //     return $this->profile_photo_path
    //         ? asset('storage/' . $this->profile_photo_path)
    //         : asset('images/default-avatar.png');
    // }
}