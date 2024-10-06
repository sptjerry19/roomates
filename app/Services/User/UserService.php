<?php

namespace App\Services\User;

use App\Services\Base\BaseServiceInterface;

interface UserService extends BaseServiceInterface
{
    public function getUser($email): mixed;

    public function login($user, $password): mixed;
}
