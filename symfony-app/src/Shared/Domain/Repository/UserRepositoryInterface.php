<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Model\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function fetchUsers(array $filters): array;

    public function fetchUser(int $id): ?User;

    public function createUser(array $data): void;

    public function updateUser(int $id, array $data): void;

    public function deleteUser(int $id): void;
}
