<?php

namespace App\Hexagon\Domain\Component;

use App\Hexagon\Infrastructure\API\NotifierInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class AbstractNotifier
 * @package App\Hexagon\Domain\Component
 */
abstract class AbstractNotifier implements NotifierInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string|null $to
     * @return string
     */
    abstract function send(string $to = null): string;

    /**
     * @return MailerInterface
     */
    public function getMailer(): MailerInterface
    {
        return $this->mailer;
    }
}