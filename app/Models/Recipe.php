<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'servings',
        'preparation_time',
        'cooking_time',
        'total_time',
        'tags',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function instructions(): HasMany
    {
        return $this->hasMany(Instruction::class)->orderBy('step_number');
    }

    public function tags(): array
    {
        return array_map(
            fn($value) =>
            $value['name'],
            Tag::select('name')->whereIn('id', json_decode($this->tags))->get()->toArray()
        );
    }
}
