<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'servings' => $this->servings,
            'preparation_time' => $this->preparation_time,
            'cooking_time' => $this->cooking_time,
            'total_time' => $this->total_time,
            'ingredients' => array_map(fn($value) => $value['full'], $this->ingredients->toArray()),
            'instructions' => array_map(fn($value) => $value['full'], $this->instructions->toArray()),
            'tags' => $this->tags(),
            'author' => $this->user->name,
            'image' => config('app.url') . Storage::url($this->image),
        ];
    }
}
