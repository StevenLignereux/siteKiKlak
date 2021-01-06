<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 * @package App\Controller
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig');
    }

    /**
     * @Route ("/post/{slug}", name="post_detail")
     * @param $slug
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function details($slug, PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $post = $postRepository->findOneBy(['slug' => $slug]);


        if (!$post){
            throw new NotFoundHttpException("Pas d'articles trouvé");
        }

        return $this->render('post/details.html.twig', [
            'categories' => $categories,
            'post' => $post
        ]);
    }
}
