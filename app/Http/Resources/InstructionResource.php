<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResource extends JsonResource
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
            'step_number' => $this->step_number,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d h:i:s a'),
        ];
    }
}
