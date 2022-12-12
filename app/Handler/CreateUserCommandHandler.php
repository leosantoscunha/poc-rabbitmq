<?php

namespace App\Commands;

use App\Models\User;

final class CreateUserCommandHandler
{
    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->id = $command->getId();
        $user->name = $command->getName();
        $user->password = bcrypt($command->getPassword());
        $user->email = $command->getEmail();

        $user->save();
    }
}
