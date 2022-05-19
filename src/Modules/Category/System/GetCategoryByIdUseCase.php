<?php

namespace SpeackWithUs\Modules\Category\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

class GetCategoryByIdUseCase
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }

    public function execute(int $id)
    {
        $categories = $this->categoryRepository->getById($id);
        return Result::Ok($categories);
    }
}
