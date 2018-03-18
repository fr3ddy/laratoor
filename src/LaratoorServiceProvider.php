<?php

namespace Fr3ddy\Laratoor;

use Illuminate\Support\ServiceProvider;

class LaratoorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Fr3ddy\Laratoor\ToornamentApi',function($app){
            return new Fr3ddy\Laratoor\ToornamentApi();
        });
        $this->app->singleton('Fr3ddy\Laratoor\ViewerApi',function($app){
            return new Fr3ddy\Laratoor\ViewerApi();
        });
        $this->app->singleton('Fr3ddy\Laratoor\AccountApi',function($app){
            return new Fr3ddy\Laratoor\AccountApi();
        });
    }
}
