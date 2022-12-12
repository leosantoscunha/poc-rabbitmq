<?php

namespace App;

use Illuminate\Bus\Dispatcher;

final class IlluminateCommandBus implements CommandBus
{
    private Dispatcher $bus;

    public function __construct(Dispatcher $bus) {
        $this->bus = $bus;
    }

    public function handle($command): void
    {
        $this->bus->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
