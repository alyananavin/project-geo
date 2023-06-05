<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

/**
 * Class UserService.
 *
 * @package App\Services
 */
class UserService
{
    /**
     * User Service constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create new user data.
     *
     * @param array $data
     * @return \App\Models\User User Model
     */
    public function create(array $data = []): User|bool|null
    {
        return $this->userRepository->create($data);
    }

    /**
     * Get user data by ID.
     *
     * @param int $userId
     * @return \App\Models\User User Model
     */
    public function getById(int $userId): User|bool|null
    {
        return $this->userRepository->getById($userId);
    }

    /**
     * Update user data.
     *
     * @param array $data
     * @param int $userId
     * @return \App\Models\User User Model
     */
    public function update(array $data = [], int $userId): User|bool|null
    {
        return $this->userRepository->update($data, $userId);
    }
}
