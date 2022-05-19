<?php

namespace SpeackWithUs\Modules\User\Controllers;

use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\User\System\UpdateUserStateUseCase;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\User\Repositories\UserRepository;

class UpdateUserStateController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {

        $userUseCase = new UpdateUserStateUseCase(
            new UserRepository
        );

        $result = $userUseCase->execute(
            intval($args["id"])
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("update/{$args['id']}/user-state?status=400&msg={$result->errorValue()}");
        }

        redirect("users?status=400&msg={$result->getValue()}");
    }
}
