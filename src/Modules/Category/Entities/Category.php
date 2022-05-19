<?php

namespace SpeackWithUs\Modules\Category\Entities;

use SpeackWithUs\Domain\{Entity, Result};
use SpeackWithUs\Modules\Category\Entities\Dto\CategoryProps;

use SpeackWithUs\Modules\Category\Validator\Name;

class Category extends Entity
{
    public int $id;
    public string $name;
    public bool $state;

    private function __construct(CategoryProps $props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    private static function againstNullOrEmpty(string $name)
    {
        return ($name !== "" ? true : false);
    }

    public static function execute(CategoryProps $props, ?int $id = null)
    {
        if (
            Name::isValid($props->name)
        ) {
            return Result::Fail("Nome informado inválido");
        }

        $bulkValidator = Category::againstNullOrEmpty(
            $props->name
        );

        if (!$bulkValidator) {
            return Result::Fail("Por favor, verifique se os dados estão devidamente preenchidos!");
        }

        $categoryProps = new Category($props, $id);

        return Result::Ok($categoryProps);
    }
}
