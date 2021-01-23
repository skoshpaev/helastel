<?php

namespace App\Tests\Hexagon\Domain\Component;

use App\Hexagon\Domain\Component\MeetingNotifier;
use App\Hexagon\Domain\Entity\User;
use App\Hexagon\Infrastructure\Repository\UserRepository;
use App\Tests\AbstractClass;
use Symfony\Component\Mailer\MailerInterface;

class MeetingNotifierTest extends AbstractClass
{
    private MeetingNotifier $notifier;
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
        $this->notifier = new MeetingNotifier($repository, $mailer);
    }

    /**
     * Tests with last message
     */
    public function testSend()
    {
        $string = $this->notifier->send();
        $this->assertEquals('Reminds have been sent for 2 employees', $string);
    }
}
