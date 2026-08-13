<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function createUser(
        string $name,
        string $email,
        string $password
    ): int {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->userRepository->create(
            $name,
            $email,
            $hashedPassword
        );
    }
    public function getUsers(): array
    {
        return $this->userRepository->findAll();
    }
    public function getUserById(int $id): ?array
    {
        return $this->userRepository->findById($id);
    }
   public function updateUser(
        int $id,
        string $name,
        string $email
    ): bool {
        return $this->userRepository->update(
            $id,
            $name,
            $email
        );
    }
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}