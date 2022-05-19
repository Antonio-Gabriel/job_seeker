<?php

namespace SpeackWithUs\Modules\Project\Controllers;

use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;
use SpeackWithUs\Modules\Project\System\CreateProjectUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateProjectController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $convertStartDateToDate = strtotime($req->getParsedBody()["startDate"]);
        $convertEndDateToDate = strtotime($req->getParsedBody()["endDate"]);

        $startDate = date("Y/m/d", $convertStartDateToDate);
        $endDate = date("Y/m/d", $convertEndDateToDate);

        $projectUseCase = new CreateProjectUseCase(
            new ProjectRepository
        );

        $result = $projectUseCase->execute(
            new ProjectProps(
                intval($req->getParsedBody()["reference"]),
                intval($req->getParsedBody()["category"]),
                $req->getParsedBody()["name"],
                $req->getParsedBody()["description"],
                $req->getParsedBody()["habilities"],
                $req->getParsedBody()["price"],
                $startDate,
                $endDate
            )
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("project-create?status=400&msg={$result->errorValue()}");
        }

        redirect("project-create?status=200&msg={$result->getValue()}");
    }
}
