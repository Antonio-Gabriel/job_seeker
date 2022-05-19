<?php

namespace SpeackWithUs\Modules\Account\Controllers;

use SpeackWithUs\Modules\Account\System\UpdateAccoutBulkUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\Account\Repositories\AccountRepository;

class UpdateUserAccountController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $updateBulkUseCase = new UpdateAccoutBulkUseCase(
            new AccountRepository
        );

        $result = $updateBulkUseCase->execute(
            $req->getParsedBody()
        );

        if ($result->getValue()) {

            $_SESSION["user"] = $result->getValue()[0];

            redirect("profile?status=200&msg=Perfil actualizado com sucesso");
        }

        redirect("profile?status=400&msg=Erro ao actualizar o perfil");
    }
}
