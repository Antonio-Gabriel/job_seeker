<?php

namespace SpeackWithUs\Modules\Category\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Category\Entities\Dto\CategoryProps;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

use SpeackWithUs\Modules\Category\Entities\Category;

class CreateCategoryUseCase
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }

    public function execute(CategoryProps $request)
    {
        $category = Category::execute(
            new CategoryProps(
                $request->name,
                $request->state
            )
        );

        $error = $category->errorValue();

        if ($error) {
            return Result::Fail($category->errorValue());
        }

        $categoryAlreadyExists = $this->categoryRepository->findByName(
            $category->getValue()->props->name
        );

        if ($categoryAlreadyExists) {
            return Result::Fail("Categoria já existe!");
        }

        $statement = $this->categoryRepository->create(
            $category->getValue()->props
        );

        if ($statement) {
            return Result::Ok("Categoria cadastrado com sucesso!");
        }
    }
}
