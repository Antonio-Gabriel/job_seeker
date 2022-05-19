<?php

namespace SpeackWithUs\Modules\User\Entities\Dto;

class UserProps
{
    public ?int $id;
    public string $name;
    public string $phone;
    public string $city;
    public string $district;
    public string $road;
    public string $email;
    public int $admin;
    public int $state;

    public function __construct(
        string $name,
        string $phone,
        string $city,
        string $district,
        string $road,
        string $email,
        int $admin = 0,
        int $state = 1,
        ?int $id = null

    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->city = $city;
        $this->district = $district;
        $this->road = $road;
        $this->email = $email;
        $this->admin = $admin;
        $this->state = $state;
    }
}
