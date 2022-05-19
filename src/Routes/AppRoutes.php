<?php

use Slim\App;
use SpeackWithUs\Auth\Authorization;
use SpeackWithUs\Config\Template;
use SpeackWithUs\Modules\Enrollment\Repositories\EnrollmentRepository;
use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;
use SpeackWithUs\Modules\Project\System\{
    GetProjectByIdUseCase,
    GetAllProjectsUseCase,
    GetFilterByProjectUseCase
};

use SpeackWithUs\Modules\Enrollment\System\GetSubscribeWorkUseCase;

return function (App $app) {
    $app->get("/", function () {
        $template = new Template();
        $template->render("index.html", [
            "user" => $_SESSION["user"]
        ]);
    });

    $app->get("/search", function ($req) {

        $search_input = @$req->getQueryParams()["search"];
        $search = isset($search_input) ? $search_input : "";

        $projects = [];

        if ($search !== "") {
            $projectUseCase = new GetFilterByProjectUseCase(
                new ProjectRepository
            );

            $projects["data"] = $projectUseCase
                ->execute($search)
                ->getValue();
        } else {
            $projectUseCase = new GetAllProjectsUseCase(
                new ProjectRepository
            );

            $projects["data"] = $projectUseCase
                ->execute()
                ->getValue();
        }

        $template = new Template();
        $template->render("search.html", [
            "projects" => $projects["data"],
            "user" => $_SESSION["user"],
            "search" => $search
        ]);
    });

    $app->get("/signIn", function ($req, $res) {
        Authorization::notAuthenticatedUser();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();
        $template->render("signIn.html", [
            "status" => $statusCode,
            "message" => $message,
        ]);
    });

    $app->get("/signUp", function ($req, $res) {
        Authorization::notAuthenticatedUser();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();
        $template->render("signUp.html", [
            "status" => $statusCode,
            "message" => $message,
        ]);
    });

    $app->get("/details/{id}", function ($req, $res, $args) {

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $projectUseCase = new GetProjectByIdUseCase(
            new ProjectRepository
        );

        $project = $projectUseCase->execute(
            intval($args["id"])
        );

        $template = new Template();
        $template->render("job-details.html", [
            "project" => $project->getValue()[0],
            "user" => $_SESSION["user"],
            "status" => $statusCode,
            "message" => $message,
        ]);
    });

    $app->get("/profile", function ($req, $res) {
        Authorization::authenticatedUser();

        $subscribeWorksUseCase = new GetSubscribeWorkUseCase(
            new EnrollmentRepository
        );

        $jobs = $subscribeWorksUseCase->execute(
            intval($_SESSION["user"]["id"])
        );

        $template = new Template();
        $template->render("profile.html", [
            "user" => $_SESSION["user"],
            "jobs" => $jobs->getValue()
        ]);
    });

    $app->get("/user/projects", function ($req) {
        Authorization::authenticatedUser();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $subscribeWorksUseCase = new GetSubscribeWorkUseCase(
            new EnrollmentRepository
        );

        $jobs = $subscribeWorksUseCase->execute(
            intval($_SESSION["user"]["id"])
        );

        $template = new Template();
        $template->render("projects.html", [
            "user" => $_SESSION["user"],
            "status" => $statusCode,
            "message" => $message,
            "jobs" => $jobs->getValue()
        ]);
    });
};
