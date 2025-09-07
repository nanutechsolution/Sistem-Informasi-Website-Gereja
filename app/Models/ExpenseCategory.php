<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ks_id'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    function kas(): BelongsTo
    {
        return $this->belongsTo(Kas::class, 'ks_id');
    }
}