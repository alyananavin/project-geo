<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Config\Repository as BaseRepository;

class UserRepository extends BaseRepository
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function getById(int $userId)
    {
        return $this->user->findOrFail($userId);
    }

    public function update(array $data, int $userId)
    {
        $user = $this->getById($userId);
        $user->fill($data);
        $user->save();

        return $user;
    }
}
