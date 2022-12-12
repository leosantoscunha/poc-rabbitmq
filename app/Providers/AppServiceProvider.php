<?php

namespace App\Providers;

use App\CommandBus;
use App\Commands\CreateProductCommand;
use App\Commands\CreateProductCommandHandler;
use App\Commands\CreateUserCommand;
use App\Commands\CreateUserCommandHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);

        $bus->map([
            CreateProductCommand::class => CreateProductCommandHandler::class,
            CreateUserCommand::class => CreateUserCommandHandler::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
