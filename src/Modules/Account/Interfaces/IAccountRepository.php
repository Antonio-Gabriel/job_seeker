<?php

namespace SpeackWithUs\Modules\Account\Interfaces;

use SpeackWithUs\Modules\Account\Entities\Dto\AccountProps;

interface IAccountRepository
{
    public function get();
    public function getById(int $id);

    public function update(AccountProps $props, int $id);
    public function create(AccountProps $props);
    public function delete(int $id);

    public function updateAccountBulk(array ...$args);
}
