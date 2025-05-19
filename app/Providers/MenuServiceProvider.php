<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    public function boot(): void
    {
        $fishermanMenuJson = file_get_contents(base_path('resources/menu/fisherman-menu.json'));
        $consumerMenuJson = file_get_contents(base_path('resources/menu/consumer-menu.json'));

        $fishermanMenu = json_decode($fishermanMenuJson);
        $consumerMenu = json_decode($consumerMenuJson);

        View::composer('*', function ($view) use ($fishermanMenu, $consumerMenu) {
            $user = Auth::user();

            if ($user && $user->role === 'Fisher') {
                $view->with('menuData', [$fishermanMenu]);
            } else {
                $view->with('menuData', [$consumerMenu]);
            }
        });
    }
}
