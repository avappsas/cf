<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\HomeController;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Definir lógica para compartir datos con todas las vistas
        view()->composer('*', function ($view) {
            // Aquí colocas la lógica para obtener los datos del menú
            // Suponiendo que tengas una función en tu controlador para obtener el menú
            $menu = app('App\Http\Controllers\HomeController')->obtenerMenu();
            // Compartir la variable de menú con todas las vistas
            $view->with('menu', $menu);
        });
    }
}
