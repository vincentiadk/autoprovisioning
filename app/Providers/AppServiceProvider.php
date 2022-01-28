<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use App\Models\MetroList;
use App\Observers\MetroObserver;

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
        $container = new Container();

        $container->bind(MetroObserver::class, function ($app) {
            return new MetroObserver(null);
        });
        $dispatcher = new Dispatcher($container);
        Model::setEventDispatcher($dispatcher);
        MetroList::observe(MetroObserver::class);
    }
}
