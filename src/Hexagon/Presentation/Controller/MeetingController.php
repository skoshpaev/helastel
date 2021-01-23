<?php

namespace App\Hexagon\Presentation\Controller;

use App\Hexagon\Infrastructure\API\NotifierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MeetingController
 * @package App\Hexagon\Presentation\Controller
 */
class MeetingController extends AbstractController
{
    private NotifierInterface $meetingNotifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->meetingNotifier = $notifier;
    }

    /**
     * @Route("/meeting", name="meeting")
     */
    public function index(): Response
    {
        $result = $this->meetingNotifier->send();

        return $this->render('meeting/index.html.twig', [
            'result' => $result,
        ]);
    }
}
