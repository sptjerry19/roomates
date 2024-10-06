<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function allUserShow()
    {
        return User::paginate(6);
    }
    public function storeUser($data)
    {
        return User::create($data);
    }
    public function editUser($id)
    {
        return User::find($id);
    }
    public function updateUser($id, $data)
    {
        return User::find($id)->update($data);
    }
    public function showUser($id)
    {
        return User::find($id);
    }
    public function distroyUser($id)
    {
        return User::find($id)->delete();
    }
}
