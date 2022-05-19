<?php

namespace SpeackWithUs\Modules\Project\Controllers;

use SpeackWithUs\Modules\Project\System\DeleteProjectUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteProjectController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $projectUseCase = new DeleteProjectUseCase(
            new ProjectRepository
        );

        $result = $projectUseCase->execute(
            intval($args["id"])
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("project-list?status=400&msg={$result->errorValue()}");
        }

        redirect("project-list?status=200&msg={$result->getValue()}");
    }
}
