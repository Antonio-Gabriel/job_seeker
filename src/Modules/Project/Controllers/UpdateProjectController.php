<?php

namespace SpeackWithUs\Modules\Project\Controllers;

use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;
use SpeackWithUs\Modules\Project\System\UpdateProjectUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateProjectController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $convertStartDateToDate = strtotime($req->getParsedBody()["startDate"]);
        $convertEndDateToDate = strtotime($req->getParsedBody()["endDate"]);

        $startDate = date("Y/m/d", $convertStartDateToDate);
        $endDate = date("Y/m/d", $convertEndDateToDate);

        $projectUseCase = new UpdateProjectUseCase(
            new ProjectRepository
        );

        $projectId = intval($req->getParsedBody()["id"]);

        $result = $projectUseCase->execute(
            new ProjectProps(
                intval($req->getParsedBody()["reference"]),
                intval($req->getParsedBody()["category"]),
                trim($req->getParsedBody()["name"]),
                trim($req->getParsedBody()["description"]),
                trim($req->getParsedBody()["habilities"]),
                $req->getParsedBody()["price"],
                $startDate,
                $endDate,
            ),
            $projectId
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("edit/" . $projectId . "/project?status=400&msg={$result->errorValue()}");
        }

        redirect("project-list?status=200&msg={$result->getValue()}");
    }
}
