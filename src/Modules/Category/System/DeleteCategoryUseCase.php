<?php

namespace SpeackWithUs\Modules\Category\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

class DeleteCategoryUseCase
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }

    public function execute(int $id)
    {
        $categorie = $this->categoryRepository->delete($id);

        if ($categorie) {

            return Result::Ok("Categoria desativada");
        }
    }
}
