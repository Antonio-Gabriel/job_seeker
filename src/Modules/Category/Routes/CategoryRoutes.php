<?php

use Slim\App;

use SpeackWithUs\Config\Template;

use SpeackWithUs\Modules\Category\Repositories\CategoryRepository;

use SpeackWithUs\Modules\Category\System\{
    GetAllCategoriesUseCase,
    GetCategoryByIdUseCase,
    GetCategoryByname,
};
use SpeackWithUs\Modules\Category\Controllers\{
    CreateCategoryController,
    DeleteCategoryController,
    UpdateCategoryController
};

return function (App $app) {

    $app->get("/category-create", function ($req) {
        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();
        $template->render("@admin/createCategory.html", [
            "status" => $statusCode,
            "message" => $message,
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->get("/category-list", function ($req) {

        $search_input = @$req->getQueryParams()["search"];
        $search = isset($search_input) ? $search_input : "";

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;
        $message = $req->getQueryParams()["msg"];

        $template = new Template();

        if (!$search_input) {
            $categoryUseCase = new GetAllCategoriesUseCase(
                new CategoryRepository
            );
            $getCategories = $categoryUseCase->execute();
        } else {
            $categoryUseCase = new GetCategoryByname(
                new CategoryRepository
            );
            $getCategories = $categoryUseCase->execute($search);
        }

        $template->render("@admin/listCategory.html", [
            "categories" => $getCategories->getValue(),
            "search" => $search,
            "status" => $statusCode,
            "message" => $message,
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->post("/create-category", [new CreateCategoryController, "handle"]);
    $app->post("/update-category", [new UpdateCategoryController, "handle"]);

    $app->get("/edit/{id}/category", function ($req, $res, $args) {

        $template = new Template();

        $categoryUseCase = new GetCategoryByIdUseCase(
            new CategoryRepository
        );
        $getCategorie = $categoryUseCase->execute(intval($args["id"]));

        $template->render("@admin/editCategory.html", [
            "category" => (object)$getCategorie->getValue()[0],
            "admin" => $_SESSION["admin"]
        ]);
    });

    $app->get("/delete/{id}/category", [new DeleteCategoryController, "handle"]);
};
