<?php

namespace SpeackWithUs\Modules\Account\Controllers;

use SpeackWithUs\Modules\Account\Entities\Dto\AccountProps;
use SpeackWithUs\Modules\Account\System\CreateAccountUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\User\Entities\Dto\UserProps;
use SpeackWithUs\Modules\User\System\CreateUserUseCase;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\Account\Repositories\AccountRepository;
use SpeackWithUs\Modules\User\Repositories\UserRepository;

class CreateAccountController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $userUseCase = new CreateUserUseCase(
            new UserRepository
        );

        $accountUseCase = new CreateAccountUseCase(
            new AccountRepository
        );

        $userResult = $userUseCase->execute(
            new UserProps(
                $req->getParsedBody()["name"],
                $req->getParsedBody()["phone"],
                "", "", "",
                $req->getParsedBody()["email"],
                1
            )
        );
        
        $userError = $userResult->errorValue();

        if ($userError) {
            redirect("register?status=400&msg={$userResult->errorValue()}");
        }

        $result = $accountUseCase->execute(
            new AccountProps(
                $userResult->getValue(),
                $req->getParsedBody()["password"],
                "", "Admin"
            )
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("register?status=400&msg={$result->errorValue()}");
        }

        redirect("backoffice?status=200&msg={$result->getValue()}");
    }
}
