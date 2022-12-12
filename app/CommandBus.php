<?php

namespace App;

interface CommandBus
{
    public function handle($command): void;
    public function map(array $map): void;
}
