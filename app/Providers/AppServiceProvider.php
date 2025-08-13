<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use App\Models\BaseDato;
use App\Observers\BaseDatoObserver;
use App\Models\Contrato;
use App\Observers\ContratoObserver;
use App\Models\Cuota;
use App\Observers\CuotaObserver;
use App\Models\CargueArchivo;
use App\Observers\CargueArchivoObserver;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Notifications\ChannelManager;
use App\Notifications\Channels\WhatsAppChannel;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
        public function boot()
        {
            Carbon::setLocale('es');
            Paginator::useBootstrap();

            BaseDato::observe(BaseDatoObserver::class);
            Contrato::observe(ContratoObserver::class);
            Cuota::observe(CuotaObserver::class);
            CargueArchivo::observe(CargueArchivoObserver::class);
            User::observe(UserObserver::class);

            // ✅ Registro del canal personalizado de WhatsApp
            app(ChannelManager::class)->extend('whatsapp', function ($app) {
                return new WhatsAppChannel();
            });
        }
 
}
