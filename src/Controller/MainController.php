<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route ("/about", name="app_about")
     * @return Response
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/team", name="app_team")
     * @return Response
     */
    public function team(): Response
    {
        return $this->render('main/team.html.twig');
    }
}
