<?php

namespace App\Hexagon\Infrastructure\Repository;

use App\Hexagon\Domain\Component\RepositoryMock;
use App\Hexagon\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Just a doctrine repository
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private RepositoryMock $repositoryMock;

    public function __construct(ManagerRegistry $registry, RepositoryMock $repositoryMock)
    {
        $this->repositoryMock = $repositoryMock;
        parent::__construct($registry, User::class);
    }

    /**
     * Mocking data - return distinct data
     *
     * @return int[]
     */
    public function findAllUsers(): array
    {
        return $this->repositoryMock->findAllUsers();
    }

}
