<?php

use Slim\App;

use SpeackWithUs\Config\Template;
use SpeackWithUs\Auth\Authorization;
use SpeackWithUs\Modules\User\Repositories\UserRepository;
use SpeackWithUs\Modules\User\System\GetAllUsersUseCase;

use SpeackWithUs\Modules\User\Controllers\UpdateUserStateController;
use SpeackWithUs\Modules\Account\Controllers\{
    AuthenticateController,
    CreateUserAccountController,
    UpdateUserAccountController
};

return function (App $app) {

    $app->get("/users", function () {
        Authorization::authenticate();

        $userUseCase = new GetAllUsersUseCase(
            new UserRepository
        );

        $users = $userUseCase->execute();

        $template = new Template();
        $template->render("@admin/users.html", [
            "admin" => $_SESSION["admin"],
            "users" => $users->getValue()
        ]);
    });

    $app->get("/profile-edit", function () {
        Authorization::authenticatedUser();

        $template = new Template();
        $template->render("edit-profile.html", [
            "user" => $_SESSION["user"]
        ]);
    });

    $app->post("/profile-update", [new UpdateUserAccountController, "handle"]);

    $app->get("/update/{id}/user-state", [new UpdateUserStateController, "handle"]);
    $app->post("/register-user", [new CreateUserAccountController, "handle"]);
    $app->post("/auth-user", [new AuthenticateController, "handle"]);
    $app->get("/logout-user", [new AuthenticateController, "Logout"]);
};
