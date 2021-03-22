<?php

namespace Laravel\Extracommands;

use Laravel\Extracommands\Console\Commands\GenrateView;
use Illuminate\Support\ServiceProvider;

class ExtraCommandsProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenrateView::class
            ]);
        }

        $this->publishes([
            __DIR__.'/Console/Commands/Stubs/make-view.stub' => app_path('Stubs/view.stub'),
        ]);
    }

     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){

    }
}
