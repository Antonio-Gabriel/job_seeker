<?php

namespace SpeackWithUs\Modules\Category\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

class GetCategoryByname
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }

    public function execute(string $name)
    {
        $categories = $this->categoryRepository->filterByName($name);
        return Result::Ok($categories);
    }
}
