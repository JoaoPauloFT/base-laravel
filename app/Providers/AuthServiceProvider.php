<?php

namespace App\Providers;

use App\Models\Totem;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function (?User $user, $permission) {
            if ($user && $user->permissions()->contains($permission)) {
                return true;
            }
            if ($user && $user->isAdmin == '1') {
                return true;
            }
        });

        Gate::define('api-key', function (?User $user) {
            try {
                $request = request();
                $header = $request->headers->all();

                if (!isset($header['apikey'])) {
                    return false;
                }

                $totem = Totem::where('apiKey', $header['apikey'])->first();

                if (!$totem) {
                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return response()->json(['message' => $e], 404);
            }
        });

        Gate::define('show', function (User $user, string $totem) {
            return $user->church_id == $totem || $user->role_id != 1;
        });

        Gate::define('filter', function (User $user) {
            return $user->role_id != 1;
        });
    }
}
