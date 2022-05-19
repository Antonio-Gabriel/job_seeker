<?php

namespace SpeackWithUs\Modules\Enrollment\Controllers;

use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SpeackWithUs\Modules\Enrollment\System\ApprovedUserToJobUseCase;
use SpeackWithUs\Modules\Enrollment\Repositories\EnrollmentRepository;

class ApprovedToJobController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $approvedToJob = new ApprovedUserToJobUseCase(
            new EnrollmentRepository
        );

        $result = $approvedToJob->execute(
            intval($req->getParsedBody()["projectId"]),
            intval($req->getParsedBody()["userId"])
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("project/{$args['projectId']}/user/{$args['userId']}?status=400&msg={$result->errorValue()}");
        }

        redirect("activities?status=200&msg={$result->getValue()}");
    }
}
