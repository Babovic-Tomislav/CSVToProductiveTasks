<?php


namespace App\Providers;


use App\Services\Productive;
use Carbon\Laravel\ServiceProvider;

class ProductiveProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Productive::class, function (){
            return new Productive();
        });
    }
}