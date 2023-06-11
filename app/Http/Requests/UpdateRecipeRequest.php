<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
    */
    // public function authorize(Recipe $recipe): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'servings' => 'required|numeric',
            'preparation_time' => 'required|numeric',
            'cooking_time' => 'required|numeric',
            'total_time' => 'required|numeric',
            'tags' => 'required|array',
        ];
    }
}
