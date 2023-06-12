<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InstructionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $recipe = new RecipeResource($this['recipe']);
        $recipe = $recipe->toArray($request);

        unset($recipe['ingredients']);

        return $recipe;
    }
}
