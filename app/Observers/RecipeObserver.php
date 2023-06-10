<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Models\Instruction;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class RecipeObserver
{
    public function creating(Recipe $recipe): void
    {
        $recipe->user_id = auth()->id();
    }

    public function saving(Recipe $recipe): void
    {
        $recipe->tags = json_encode(
            array_map(fn($value) => Tag::firstOrCreate(['name' => $value])->id, request()->get('tags'))
        );
    }

    public function saved(Recipe $recipe): void
    {
        $recipe->image = request()->file('image')->store("public/images/$recipe->id");
        $recipe->saveQuietly();
    }
    /**
     * Handle the Recipe "created" event.
     */
    public function created(Recipe $recipe): void
    {
        array_map(
            fn($ingredient) =>
            Ingredient::create([...$ingredient, 'recipe_id' => $recipe->id])
            , request()->get('ingredients')
        );

        array_map(
            fn($instructions) =>
            Instruction::create([...$instructions, 'recipe_id' => $recipe->id])
            , request()->get('instructions')
        );
    }

    /**
     * Handle the Recipe "updated" event.
     */
    public function updated(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "deleted" event.
     */
    public function deleted(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "restored" event.
     */
    public function restored(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "force deleted" event.
     */
    public function forceDeleted(Recipe $recipe): void
    {
        //
    }

    public function retrieved(Recipe $recipe): void
    {
        // $recipe->tags = array_map(fn($value) => $value['name'], Tag::select('name')->whereIn('id', json_decode($recipe->tags))->get()->toArray());
        $recipe->image = config('app.url') . Storage::url($recipe->image);
        $recipe->instructions = array_map(fn($value) => "{$value['step_number']} {$value['description']}", $recipe->instructions->toArray());
        $recipe->ingredients = array_map(fn($value) => "{$value['quantity']} {$value['unit']} {$value['name']}", $recipe->ingredients->toArray());
    }
}
