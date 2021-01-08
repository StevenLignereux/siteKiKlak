<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     * @param EventRepository $eventRepository
     * @return Response
     */
    public function index(EventRepository $eventRepository): Response
    {

        return $this->render('main/carousel.html.twig', [
            'event' => $eventRepository->findAll()
        ]);
    }
}
