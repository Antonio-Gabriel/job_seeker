<?php

namespace SpeackWithUs\Modules\Category\Interfaces;

use SpeackWithUs\Modules\Category\Entities\Dto\CategoryProps;

interface ICategoryRepository
{
    public function get();
    public function getById(int $id);
    public function findByName(string $name);
    public function filterByName(string $name);
    public function create(CategoryProps $props);
    public function update(CategoryProps $props, int $id);

    public function delete(int $id);
}
