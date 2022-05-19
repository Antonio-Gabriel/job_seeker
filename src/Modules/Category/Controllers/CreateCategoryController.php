<?php

namespace SpeackWithUs\Modules\Category\Controllers;

use SpeackWithUs\Modules\Category\Entities\Dto\CategoryProps;
use SpeackWithUs\Modules\Category\System\CreateCategoryUseCase;
use SpeackWithUs\Modules\Category\Controllers\Contracts\IHandle;

use SpeackWithUs\Modules\Category\Repositories\CategoryRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCategoryController implements IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args)
    {
        $categoryUseCase = new CreateCategoryUseCase(
            new CategoryRepository
        );

        $result = $categoryUseCase->execute(
            new CategoryProps(
                $req->getParsedBody()["name"],
                $req->getParsedBody()["state"]
            )
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("category-create?status=400&msg={$result->errorValue()}");
        }

        redirect("category-create?status=200&msg={$result->getValue()}");
    }
}
