<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateProductCommand;

class ProductController extends Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $command)
    {
        $this->commandBus = $command;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        // $this->authorize('...')
        $name = request()->get('name');
        $price = request()->get('price');

        // validation goes here ...
        $command = new CreateProductCommand($name, $price);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }

}
