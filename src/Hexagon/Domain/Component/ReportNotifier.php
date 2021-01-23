<?php

namespace App\Hexagon\Domain\Component;

use App\Hexagon\Infrastructure\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Sends a report
 * Class ReportNotifier
 * @package App\Hexagon\Domain\Component
 */
class ReportNotifier extends AbstractNotifier
{
    const REPORT = 'Report';
    const FROM = 'admin@admin.com';
    const HTML_TEMPLATE = 'emails/Report.html.twig';
    const SUCCESS_MESSAGE = 'Report have been successfully sent';

    private UserRepository $userRepository;

    /**
     * ReportNotifier constructor.
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
        $name = $this->getStringNamesFromUsers($users);
        $age = $this->getStringAgesFromUsers($users);
        $user_email = $this->getStringEmailsFromUsers($users);

        $email = (new TemplatedEmail())
            ->from(self::FROM)
            ->to(new Address($to))
            ->subject(self::REPORT)
            ->htmlTemplate(self::HTML_TEMPLATE)
            ->context([
                'name' => $name,
                'age' => $age,
                'user_email' => $user_email,
            ]);

        try {
            $this->getMailer()->send($email);
        } catch (TransportExceptionInterface $e) {
            return 'Something went wrong: ' . $e->getMessage() . ' But it could be sent with such parameters: ' .
                'names '. $name . '; ' .
                'ages ' . $age . '; ' .
                'emails' . $user_email ;
        }

        return self::SUCCESS_MESSAGE;
    }

    /**
     * @param array $users
     * @return string
     */
    private function getStringNamesFromUsers(array $users): string
    {
        $string = '';

        for ($i = 0; $i < count($users); $i++) {
            if ($i != count($users) - 1) {
                $string .= $users[$i]->getName() . ', ';
                continue;
            }

            $string .= $users[$i]->getName();
        }

        return $string;
    }

    /**
     * @param array $users
     * @return string
     */
    private function getStringAgesFromUsers(array $users): string
    {
        $string = '';

        for ($i = 0; $i < count($users); $i++) {
            if ($i != count($users) - 1) {
                $string .= $users[$i]->getAge() . ', ';
                continue;
            }

            $string .= $users[$i]->getAge();
        }

        return $string;
    }

    /**
     * @param array $users
     * @return string
     */
    private function getStringEmailsFromUsers(array $users): string
    {
        $string = '';

        for ($i = 0; $i < count($users); $i++) {
            if ($i != count($users) - 1) {
                $string .= $users[$i]->getEmail() . ', ';
                continue;
            }

            $string .= $users[$i]->getEmail();
        }

        return $string;
    }
}