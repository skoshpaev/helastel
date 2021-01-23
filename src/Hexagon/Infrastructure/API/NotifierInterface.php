<?php

namespace App\Hexagon\Infrastructure\API;

use Symfony\Component\Mailer\MailerInterface;

/**
 * Common interface for all notifiers
 *
 * Interface NotifierInterface
 * @package App\Hexagon\Infrastructure\API
 */
interface NotifierInterface
{
    public function send(string $to = null): string;
}