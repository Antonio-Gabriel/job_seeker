<?php

namespace SpeackWithUs\Modules\Enrollment\Controllers;

use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\Enrollment\System\ApplyToWotkUseCase;
use SpeackWithUs\Modules\Enrollment\Repositories\EnrollmentRepository;

class ApplyToJobController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $applyNow = new ApplyToWotkUseCase(
            new EnrollmentRepository
        );

        $result = $applyNow->execute(intval($args["id"]), intval($_SESSION["user"]["id"]));

        $error = $result->errorValue();

        if ($error) {
            redirect("details/{$args['id']}?status=400&msg={$result->errorValue()}");
        }

        redirect("user/projects?status=200&msg={$result->getValue()}");
    }
}
