<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateUserCommand;
use App\Models\User;
use Ramsey\Uuid\Uuid;

final class CreateUserController extends Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $command)
    {
        $this->commandBus = $command;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $id = Uuid::uuid4();

        $command = new CreateUserCommand(
            $id,
            request()->get('name'),
            request()->get('email'),
            request()->get('password'),
        );
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
            'data' => User::find($id)
        ]);
    }
}
