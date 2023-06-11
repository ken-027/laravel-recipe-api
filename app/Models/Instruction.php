<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['step_number', 'description', 'recipe_id'];
    protected $appends = ['full'];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function getFullAttribute(): string
    {
        return "$this->step_number $this->description";
    }
}
