<?php

namespace App;

use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    private Dispatcher $bus;

    protected $handlers = [];

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
