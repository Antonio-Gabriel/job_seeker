<?php

use Slim\App;

use SpeackWithUs\Config\Template;

use SpeackWithUs\Modules\Category\Repositories\CategoryRepository;
use SpeackWithUs\Modules\Category\System\GetAllCategoriesUseCase;

use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;
use SpeackWithUs\Modules\Project\Controllers\{
    CreateProjectController,
    UpdateProjectController,
    DeleteProjectController
};

use SpeackWithUs\Modules\Project\System\{
    GetProjectByIdUseCase,
    GetAllProjectsUseCase,
    GetFilterByProjectUseCase,
    GetFilterByReferenceUseCase
};

return function (App $app) {

    $app->get("/project-create", function ($req) {
        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $categoryUseCase = new GetAllCategoriesUseCase(
            new CategoryRepository
        );

        $categories = $categoryUseCase->execute();

        $template = new Template();
        $template->render("@admin/createProject.html", [
            "status" => $statusCode,
            "message" => $message,
            "categories" => $categories->getValue(),
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->post("/create-project", [new CreateProjectController, "handle"]);

    $app->get("/project-list", function ($req) {
        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $searchInput = @$req->getQueryParams()["search"];
        $search = isset($searchInput) ? $searchInput : "";

        $searchInputReference = @$req->getQueryParams()["searchReference"];
        $searchReference = isset($searchInputReference) ? $searchInputReference : "";

        if ($searchInput) {
            $projectsUseCase = new GetFilterByProjectUseCase(
                new ProjectRepository
            );

            $getProjects = $projectsUseCase->execute($search);
        } else if ($searchInputReference) {
            $projectsUseCase = new GetFilterByReferenceUseCase(
                new ProjectRepository
            );

            $getProjects = $projectsUseCase->execute($searchReference);
        } else {
            $projectsUseCase = new GetAllProjectsUseCase(
                new ProjectRepository
            );

            $getProjects = $projectsUseCase->execute();
        }

        $template = new Template();
        $template->render("@admin/listProject.html", [
            "status" => $statusCode,
            "message" => $message,
            "projects" => $getProjects->getValue(),
            "search" => $search,
            "searchReference" => $searchReference,
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->post("/update-project", [new UpdateProjectController, "handle"]);

    $app->get("/edit/{id}/project", function ($req, $res, $args) {
        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $projectUseCase = new GetProjectByIdUseCase(
            new ProjectRepository
        );

        $categoryUseCase = new GetAllCategoriesUseCase(
            new CategoryRepository
        );

        $getProject = $projectUseCase->execute(intval($args["id"]));

        $categories = $categoryUseCase->execute();

        $template = new Template();
        $template->render("@admin/editProject.html", [
            "status" => $statusCode,
            "message" => $message,
            "project" => $getProject->getValue()[0],
            "categories" => $categories->getValue(),
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->get("/delete/{id}/project", [new DeleteProjectController, "handle"]);
};
