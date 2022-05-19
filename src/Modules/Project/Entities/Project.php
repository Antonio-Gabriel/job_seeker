<?php

namespace SpeackWithUs\Modules\Project\Entities;

use SpeackWithUs\Domain\{Entity, Result};
use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;

use SpeackWithUs\Modules\Category\Validator\Name;

use DateTime;

class Project extends Entity
{
    public int $id;
    public int $reference;
    public int $categoryId;
    public string $name;
    public string $description;
    public ?DateTime $createdAt;
    public ?DateTime $finishedAt;

    private function __construct(ProjectProps $props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    private static function againstNullOrEmpty(
        int $reference,
        int $categoryId,
        string $name,
        string $description
    ) {
        if (
            $reference ==  ""
            || $categoryId == 0
            || $name == ""
            || $description == ""
        ) {

            return false;
        }

        return true;
    }

    public static function execute(ProjectProps $props, ?int $id = null)
    {
        if (Name::isValid($props->name)) {
            return Result::Fail("Nome informado inválido!");
        }

        if (Name::isValid($props->description)) {
            return Result::Fail("Descrição do projecto informado inválido!");
        }

        $bulkValidator = Project::againstNullOrEmpty(
            $props->reference,
            $props->categoryId,
            $props->name,
            $props->description
        );

        if (!$bulkValidator) {
            return Result::Fail("Por favor, verifique se os dados estão devidamente preenchidos!");
        }

        $projectProps = new Project($props, $id);

        return Result::Ok($projectProps);
    }
}
