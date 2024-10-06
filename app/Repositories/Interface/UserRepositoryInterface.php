<?php

namespace App\Repositories\Interface;

interface UserRepositoryInterface
{

    public function allUserShow();
    public function storeUser($data);
    public function editUser($id);
    public function updateUser($id, $data);
    public function showUser($id);
    public function distroyUser($id);
}
