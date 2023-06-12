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
        // $recipe = (object) $this['recipe'];
        // return [
        //     'recipe' => [
        //         'id' => $recipe->id,
        //         'name' => $recipe->name,
        //         'instruction' => InstructionResource::collection($this['collection'])
        //     ],
        // ];

        $recipe = new RecipeResource($this['recipe']);
        $recipe = $recipe->toArray($request);

        unset($recipe['ingredients']);

        return $recipe;
    }
}
