<?php

namespace App\Hexagon\Presentation\Controller;

use App\Hexagon\Infrastructure\API\NotifierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportController
 * @package App\Hexagon\Presentation\Controller
 */
class ReportController extends AbstractController
{
    private NotifierInterface $meetingNotifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->meetingNotifier = $notifier;
    }

    /**
     * @Route("/report", name="report")
     */
    public function index(): Response
    {
        $result = $this->meetingNotifier->send('admin@admin.ru');

        return $this->render('report/index.html.twig', [
            'result' => $result,
        ]);
    }
}
