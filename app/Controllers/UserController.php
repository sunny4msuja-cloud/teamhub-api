<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController
{
    public function __construct(
        private UserService $userService
    ) {}

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

       if (!$name || !$email || !$password) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Name, email and password are required'
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Invalid email address'
            ]);
            return;
        }

        if (strlen($password) < 8) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Password must be at least 8 characters'
            ]);
            return;
        }

        $userId = $this->userService->createUser(
            $name,
            $email,
            $password
        );

        http_response_code(201);

        echo json_encode([
            'message' => 'User created successfully',
            'id' => $userId
        ]);
    }

    public function index(): void
    {
        $users = $this->userService->getUsers();

        echo json_encode([
            'data' => $users
        ]);
    }
    public function show(int $id): void
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            http_response_code(404);

            echo json_encode([
                'error' => 'User not found'
            ]);

            return;
        }

        echo json_encode([
            'data' => $user
        ]);
    }
    public function update(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';

        if (!$name || !$email) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Name and email are required'
            ]);
            return;
        }

        $updated = $this->userService->updateUser(
            $id,
            $name,
            $email
        );

        if (!$updated) {
            http_response_code(404);
            echo json_encode([
                'error' => 'User not found'
            ]);
            return;
        }

        echo json_encode([
            'message' => 'User updated successfully'
        ]);
    }
    public function delete(int $id): void
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            http_response_code(404);

            echo json_encode([
                'error' => 'User not found'
            ]);

            return;
        }

        echo json_encode([
            'message' => 'User deleted successfully'
        ]);
    }
}