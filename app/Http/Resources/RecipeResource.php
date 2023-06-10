<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'tags' => $this->tags(),
            'author' => $this->user->name,
            'image' => $this->image,
        ];
    }
}
