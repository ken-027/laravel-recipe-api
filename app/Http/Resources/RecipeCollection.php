<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class RecipeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): JsonResource
    {
        return RecipeResource::collection(Cache::remember('recipes', 60, fn () => $this->collection));
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
            'author' => config('app.author'),
        ];
    }
}
