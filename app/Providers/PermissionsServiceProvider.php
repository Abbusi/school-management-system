<?php

namespace App\Providers;

use App\Http\Helpers\AppHelper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        AppHelper::getPermissions()->map(function ($permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                // For super admin no need to check permissions
                if ($user->is_super_admin) {
                    return true;
                }
                return $user->hasPermissionTo($permission);
            });
        });

        // Blade role directives
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('notrole', function ($role) {
            return "<?php if(auth()->check() && !auth()->user()->hasRole({$role})) : ?>";
        });
        Blade::directive('endnotrole', function () {
            return "<?php endif; ?>";
        });

        // Captcha directive mapping to mews/captcha helper
        Blade::directive('captcha', function () {
            return "<?php echo captcha_img(); ?>";
        });
    }
}


