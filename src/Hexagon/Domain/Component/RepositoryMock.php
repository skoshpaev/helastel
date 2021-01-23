<?php

namespace App\Hexagon\Domain\Component;

use App\Hexagon\Domain\Entity\User;

/**
 * Mocks requests to database
 * Class RepositoryMock
 * @package App\Hexagon\Domain\Component
 */
class RepositoryMock
{
    /**
     * Mocking data - return distinct data
     *
     * @return int[]
     */
    public function findAllUsers(): array
    {
        return [
            $this->getUserByData('alex@mail.com', 67, 'Alex Norton'),
            $this->getUserByData('mary@gmail.com', 18, 'Marry Shawn'),
            $this->getUserByData('dan@ya.ru', 34, 'Dan Hoff'),
        ];
    }

    private function getUserByData($email, $age, $name): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setAge($age);
        $user->setName($name);

        return $user;
    }
}