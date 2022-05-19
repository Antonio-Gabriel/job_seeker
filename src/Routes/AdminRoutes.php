<?php

use Slim\App;
use SpeackWithUs\Config\Template;

use SpeackWithUs\Auth\Authorization;

use SpeackWithUs\Modules\Category\Repositories\CategoryRepository;
use SpeackWithUs\Modules\Category\System\GetAllCategoriesUseCase;

use SpeackWithUs\Modules\Project\Repositories\ProjectRepository;
use SpeackWithUs\Modules\Project\System\GetAllProjectsUseCase;
use SpeackWithUs\Modules\User\Repositories\UserRepository;

use SpeackWithUs\Modules\User\System\GetAllUsersUseCase;

use SpeackWithUs\Modules\Account\Controllers\{
    CreateAccountController,
    AuthenticateUserController
};
use SpeackWithUs\Modules\Enrollment\Repositories\EnrollmentRepository;
use SpeackWithUs\Modules\Enrollment\System\{
    GetAllSubscribersUsersToWorkUseCase,
    GetSubscribersUsersToWorkByCategoryUseCase
};

use SpeackWithUs\Modules\Project\System\{
    GetProjectByIdUseCase
};

use SpeackWithUs\Modules\User\System\GetUserByIdUseCase;

return function (App $app) {
    $app->get("/backoffice", function ($req) {
        Authorization::notAuthenticate();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();
        $template->render("@admin/login.html", [
            "status" => $statusCode,
            "message" => $message,
        ]);
    });

    $app->post("/auth-admin", [new AuthenticateUserController, "handle"]);
    $app->get("/logout-admin", [new AuthenticateUserController, "Logout"]);

    $app->get("/register", function ($req) {
        Authorization::notAuthenticate();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();
        $template->render("@admin/register.html", [
            "status" => $statusCode,
            "message" => $message,
        ]);
    });

    $app->post("/register-admin", [new CreateAccountController, "handle"]);

    $app->get("/dashboard", function () {
        Authorization::authenticate();

        $getCategories = new GetAllCategoriesUseCase(
            new CategoryRepository
        );

        $getProjects = new GetAllProjectsUseCase(
            new ProjectRepository
        );

        $getUsers = new GetAllUsersUseCase(
            new UserRepository
        );

        $totalUsers = count($getUsers->execute()->getValue());
        $totalCourse = count($getCategories->execute()->getValue());
        $totalProject = count($getProjects->execute()->getValue());

        $template = new Template();
        $template->render("@admin/index.html", [
            "totalCategory" => $totalCourse,
            "totalProject" => $totalProject,
            "totalUser" => $totalUsers,
            "admin" => $_SESSION["admin"]
        ]);
    });

    // Others routes
    $app->get("/activities", function ($req) {
        Authorization::authenticate();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $subscribersUseCase = new GetAllSubscribersUsersToWorkUseCase(
            new EnrollmentRepository
        );

        $enrollments = $subscribersUseCase->execute();

        $template = new Template();
        $template->render("@admin/activities.html", [
            "admin" => $_SESSION["admin"],
            "status" => $statusCode,
            "message" => $message,
            "enrollmenrs" => $enrollments->getValue()
        ]);
    });

    $app->get("/enrollments", function ($req) {
        Authorization::authenticate();

        $category = intval($req->getQueryParams()["category"]) ?? 0;

        $categoryUseCase = new GetAllCategoriesUseCase(
            new CategoryRepository
        );

        $categories = $categoryUseCase->execute();

        $subscribersUseCase = new GetAllSubscribersUsersToWorkUseCase(
            new EnrollmentRepository
        );

        $subscribersByCategoryUseCase = new GetSubscribersUsersToWorkByCategoryUseCase(
            new EnrollmentRepository
        );

        $activeEnrollments = [];

        if (
            $category == 0
        ) {
            $enrollments = $subscribersUseCase->execute();
            $activeEnrollments["data"] = $enrollments->getValue();
        } else {
            $enrollments = $subscribersByCategoryUseCase->execute(
                $category
            );

            $activeEnrollments["data"] = $enrollments->getValue();
        }

        $template = new Template();
        $template->render("@admin/enrollment.html", [
            "admin" => $_SESSION["admin"],
            "categories" => $categories->getValue(),
            "enrollmenrs" => $activeEnrollments["data"]
        ]);
    });

    $app->get("/project/{projectId}/user/{userId}", function ($req, $res, $args) {
        Authorization::authenticate();

        $projectUseCase = new GetProjectByIdUseCase(
            new ProjectRepository
        );

        $userUseCase = new GetUserByIdUseCase(
            new UserRepository
        );

        $getProject = $projectUseCase->execute(intval($args["projectId"]));
        $getUser = $userUseCase->execute(intval($args["userId"]));

        $template = new Template();
        $template->render("@admin/addTask.html", [
            "admin" => $_SESSION["admin"],
            "project" => $getProject->getValue()[0],
            "user" => $getUser->getValue()[0]
        ]);
    });
};
