<?php

namespace SpeackWithUs\Modules\Project\Entities\Dto;

class ProjectProps
{
    public int $reference;
    public int $categoryId;
    public string $name;
    public string $description;
    public string $habilities;
    public $price;
    public string $createdAt;
    public string $finishedAt;

    public function __construct(
        int $reference,
        int $categoryId,
        string $name,
        string $description,
        string $habilities,
        $price,
        string $createdAt,
        string $finishedAt

    ) {
        $this->reference = $reference;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->description = $description;
        $this->habilities = $habilities;
        $this->price = $price;
        $this->createdAt = $createdAt;
        $this->finishedAt = $finishedAt;
    }
}
