<?php

namespace App\Tests\Hexagon\Domain\Component;

use App\Hexagon\Domain\Component\RepositoryMock;
use App\Hexagon\Domain\Entity\User;
use App\Tests\AbstractClass;
use ReflectionException;

class RepositoryMockTest extends AbstractClass
{
    private RepositoryMock $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = new RepositoryMock();
    }

    /**
     * Monkey test for mocked repository's method
     */
    public function testFindAllUsers()
    {
        $returned = $this->repositoryMock->findAllUsers();
        $this->assertIsArray($returned);
        $this->assertEquals(67, $returned[0]->getAge());
        $this->assertEquals('mary@gmail.com', $returned[1]->getEmail());
        $this->assertEquals('Dan Hoff', $returned[2]->getName());
        $this->assertIsObject($returned[0]);
    }

    /**
     * Monkey test for mocked repository's method
     *
     * @throws ReflectionException
     */
    public function testGetUserByData()
    {
        /** @var User $results */
        $results = $this->invokeMethod($this->repositoryMock, 'getUserByData', ['test@email.ru', 100, 'Test name']);
        $this->assertEquals('test@email.ru', $results->getEmail());
        $this->assertEquals('Test name', $results->getName());
        $this->assertEquals(100, $results->getAge());
    }
}
