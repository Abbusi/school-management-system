<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Illuminate\Database\Schema\Blueprint::macro(
            'userstamps', function () {
                $this->unsignedInteger('created_by')->nullable()->index();
                $this->unsignedInteger('updated_by')->nullable()->index();
                $this->unsignedInteger('deleted_by')->nullable()->index();
            }
        );
        \Illuminate\Database\Schema\Blueprint::macro(
            'dropUserstamps', function () {
                $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom Form facade alias for backward compatibility
        AliasLoader::getInstance()->alias('Form', \App\Http\Helpers\Form::class);

        // User caching observer
        User::observe(UserObserver::class);

        // Custom if query builder macro
        Builder::macro('if', function ($condition, $column, $operator, $value) {
            if ($condition) {
                return $this->where($column, $operator, $value);
            }

            return $this;
        });
    }
}


