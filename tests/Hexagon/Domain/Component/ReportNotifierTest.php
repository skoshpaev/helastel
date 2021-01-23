<?php

namespace App\Tests\Hexagon\Domain\Component;

use App\Hexagon\Domain\Component\ReportNotifier;
use App\Hexagon\Domain\Entity\User;
use App\Hexagon\Infrastructure\Repository\UserRepository;
use App\Tests\AbstractClass;
use ReflectionException;
use Symfony\Component\Mailer\MailerInterface;

class ReportNotifierTest extends AbstractClass
{
    private ReportNotifier $notifier;
    private array $users = [];

    /**
     * Sets up the notifier
     */
    protected function setUp(): void
    {
        $mailer = $this->getMockBuilder(MailerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->users[] = (new User())->setName('TEST1')->setAge(100)->setEmail('test@test.test');
        $this->users[] = (new User())->setName('TEST2')->setAge(200)->setEmail('test2@test2.test2');

        $repository->method('findAllUsers')->willReturn($this->users);
        $this->notifier = new ReportNotifier($repository, $mailer);
    }

    public function testSend()
    {
        $string = $this->notifier->send('qwe@ert.yui');
        $this->assertEquals('Report have been successfully sent', $string);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetStringNamesFromUsers()
    {
        $results = $this->invokeMethod($this->notifier, 'getStringNamesFromUsers', [$this->users]);
        $this->assertEquals('TEST1, TEST2', $results);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetStringAgesFromUsers()
    {
        $results = $this->invokeMethod($this->notifier, 'getStringAgesFromUsers', [$this->users]);
        $this->assertEquals('100, 200', $results);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetStringEmailsFromUsers()
    {
        $results = $this->invokeMethod($this->notifier, 'getStringEmailsFromUsers', [$this->users]);
        $this->assertEquals('test@test.test, test2@test2.test2', $results);
    }
}
