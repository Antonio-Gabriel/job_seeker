<?php

namespace SpeackWithUs\Modules\Project\Interfaces;

use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;

interface IProjectRepository
{
    public function get();
    public function getById(int $id);

    public function filterByName(string $name);
    public function filterByReference(string $reference);
    
    public function findByReference(string $reference);
    public function update(ProjectProps $props, int $id);
    
    public function create(ProjectProps $props);
    public function delete(int $id);
}
