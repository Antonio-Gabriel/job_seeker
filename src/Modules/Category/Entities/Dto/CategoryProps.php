<?php

namespace SpeackWithUs\Modules\Category\Entities\Dto;

class CategoryProps
{
    public string $name;
    public bool $state;

    public function __construct(
        string $name,
        bool $state
    ) {
        $this->name = $name;
        $this->state = $state;
    }
}
