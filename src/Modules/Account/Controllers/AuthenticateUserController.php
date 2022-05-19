<?php

namespace SpeackWithUs\Modules\Account\Controllers;

use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Account\System\AuthenticateUseCase;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\Account\Validator\Password;

class AuthenticateUserController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $accountUseCase = new AuthenticateUseCase();
        $result = $accountUseCase->execute(
            $req->getParsedBody()["email"]
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("backoffice?status=400&msg={$result->errorValue()}");
        }

        if (intval($result->getValue()[0]["estado"]) != 0) {
            if (
                Password::comparePassword(
                    $req->getParsedBody()["password"],
                    $result->getValue()[0]["palavrapasse"]
                )
            ) {
                session_start();
                session_regenerate_id();

                $_SESSION["admin"] = $result->getValue()[0];

                redirect("dashboard");
            } else {
                redirect("backoffice?status=400&msg=Usuário ou senha inválido");
            }
        } else {
            redirect("backoffice?status=400&msg=Não tem permissão para logar");
        }
    }

    public function Logout()
    {
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
        session_regenerate_id(true);

        unset($_SESSION["admin"]);

        redirect("backoffice");
    }
}
