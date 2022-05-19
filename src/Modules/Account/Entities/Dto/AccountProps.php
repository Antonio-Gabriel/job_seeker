<?php

namespace SpeackWithUs\Modules\Account\Entities\Dto;

class AccountProps
{
    public ?int $id;
    public int $userId;
    public string $password;
    public string $image;
    public string $area;
    public ?string $description;

    public function __construct(
        int $userId,
        string $password,
        string $image,
        string $area,
        ?string $description = null,
        ?int $id = null

    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->password = $password;
        $this->image = $image;
        $this->area = $area;
        $this->description = $description;
    }
}
