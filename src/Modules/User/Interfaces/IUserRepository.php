<?php

namespace SpeackWithUs\Modules\User\Interfaces;

use SpeackWithUs\Modules\User\Entities\Dto\UserProps;

interface IUserRepository
{
    public function get();
    public function getById(int $id);
    public function getAccountId(int $id);

    public function filterByName(string $name);
    public function findByEmail(string $email);
    
    public function updateUserState(int $id, int $state);

    public function update(UserProps $props, int $id);
    public function create(UserProps $props);
    public function delete(int $id);
}
