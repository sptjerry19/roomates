<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function getModel(): string
    {
        return User::class;
    }

    public function getUser($email): mixed
    {
        return $this->select()->where('email', $email)->first();
    }
}
