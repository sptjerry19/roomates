<?php

namespace App\Repositories\User;

use App\Repositories\Base\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getUser($email): mixed;
}
