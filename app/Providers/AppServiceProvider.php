<?php

namespace App\Providers;

use App\CommandBus;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Log;
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
        $this->app->make(CommandBus::class)->map($this->getCommands());
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

    private function getCommands(): array
    {
        $commands = [];

        try {

            $path = dirname(__FILE__) . "/../Handler";
            $files = scandir($path, SCANDIR_SORT_ASCENDING);
            foreach ($files as $file) {
                // Ignore directories and abstract classes.
                if (is_dir($file) || 0 === stripos($file, 'Abstract')) {
                    continue;
                }

                // Get the name of the file without the suffix.
                $file = explode('.', $file);
                $file = $file[0];

                $class = new \ReflectionClass("App\Handler\\" . $file);
                $commandHandlerClassName = $class->getName();

                $method = $class->getMethod('__invoke');

                if (null === $method) {
                    throw new InvalidArgumentException("Command handler should have method __invoke");
                }

                $command = array_filter($method->getParameters(), function ($parameter) {
                    return  $parameter->getName() === "command";
                });

                if ([] === $command) {
                    throw new InvalidArgumentException("Command handler should have least one command class");
                }

                if (count($command) > 1) {
                    throw new InvalidArgumentException("Command handler should have just one command class");
                }

                $commandClassName = $command[0]->getClass()->getName();

                $commands[$commandClassName] = $commandHandlerClassName;
            }

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return $commands;
    }
}
