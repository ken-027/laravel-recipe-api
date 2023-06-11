<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): JsonResource
    {
        return RecipeResource::collection($this->collection);
    }

    public function paginationInformation($request, $paginated, $default): array
    {
        unset($default['meta']['links']);
        unset($default['links']);

        return $default;
    }

    public function with(Request $request): array
    {
        return [
            'developer' => [
                'name' => config('app.author'),
                'email' => config('app.email')
            ],
        ];
    }
}
