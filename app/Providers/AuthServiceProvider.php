<?php

namespace App\Providers;

use App\Models\Ingredient;
use App\Models\Instruction;
use App\Models\Recipe;
use App\Models\SaveRecipe;
use App\Policies\IngredientPolicy;
use App\Policies\InstructionPolicy;
use App\Policies\RecipePolicy;
use App\Policies\SaveRecipePolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Recipe::class => RecipePolicy::class,
        SaveRecipe::class => SaveRecipePolicy::class,
        Instruction::class => InstructionPolicy::class,
        Ingredient::class => IngredientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
