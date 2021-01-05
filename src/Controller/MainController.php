<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 *
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $post = $postRepository->findAllLatest();
        return $this->render('main/index.html.twig', [
            'post' => $post
        ]);
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

    /**
     * @Route ("/contact", name="app_contact")
     * @return Response
     */
    public function contact(): Response
    {
       return $this->render('contact.html.twig');
    }


}
