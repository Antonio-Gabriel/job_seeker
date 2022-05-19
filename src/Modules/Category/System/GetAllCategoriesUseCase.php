<?php

namespace SpeackWithUs\Modules\Category\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

class GetAllCategoriesUseCase
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }

    public function execute()
    {
        $categories = $this->categoryRepository->get();
        return Result::Ok($categories);
    }
}
