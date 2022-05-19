<?php

namespace SpeackWithUs\Modules\Category\Controllers;

use SpeackWithUs\Modules\Category\System\DeleteCategoryUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Category\Repositories\CategoryRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCategoryController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $categoryUseCase = new DeleteCategoryUseCase(
            new CategoryRepository
        );

        $result = $categoryUseCase->execute(intval($args["id"]));

        $error = $result->errorValue();

        if ($error) {
            redirect("category-list?status=400&msg={$result->errorValue()}");
        }

        redirect("category-list?status=200&msg={$result->getValue()}");
    }
}
