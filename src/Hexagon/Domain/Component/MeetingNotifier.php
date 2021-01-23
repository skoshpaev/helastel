<?php

namespace App\Hexagon\Domain\Component;

use App\Hexagon\Domain\Entity\User;
use App\Hexagon\Infrastructure\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Sends a reminder about meetings
 * Class MeetingNotifier
 * @package App\Hexagon\Domain\Component
 */
class MeetingNotifier extends AbstractNotifier
{
    const REMIND = 'Remind';
    const FROM = 'admin@admin.com';
    const HTML_TEMPLATE = 'emails/Meeting.html.twig';

    private UserRepository $userRepository;

    /**
     * MeetingNotifier constructor.
     * @param UserRepository $userRepository
     * @param MailerInterface $mailer
     */
    public function __construct(
        UserRepository $userRepository,
        MailerInterface $mailer
    )
    {
        $this->userRepository = $userRepository;

        parent::__construct($mailer);
    }

    /**
     * @param string|null $to
     * @return string
     */
    public function send(string $to = null): string
    {
        $users = $this->userRepository->findAllUsers();

        $sent = [];
        /** @var User $user */
        foreach ($users as $user) {
            $email = (new TemplatedEmail())
                ->from(self::FROM)
                ->to(new Address($user->getEmail()))
                ->subject(self::REMIND)
                ->htmlTemplate(self::HTML_TEMPLATE)
                ->context([
                    'name' => $user->getName()
                ]);

            try {
                if (false === in_array($user->getEmail(), $sent)) {
                    $this->getMailer()->send($email);
                    $sent[] = $user->getEmail();
                }
            } catch (TransportExceptionInterface $e) {
                return 'Something went wrong: ' . $e->getMessage() . ' But it could be sent for about ' . count($users) . ' employees';
            }
        }

        return 'Reminds have been sent for ' . count($sent) . ' employees';
    }

}