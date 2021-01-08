<?php

namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/post", name="post")
     * @param PostRepository $postRepository
     * @param Request $request
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $post = $postRepository->findBy([], ['createdAt' => 'desc' ], 3);
        return $this->render('post/index.html.twig', compact('post'));
    }

    /**
     * @Route ("/post/{slug}", name="post_detail")
     * @param $slug
     * @param PostRepository $postRepository
     * @return Response
     */
    public function details($slug, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOneBy(['slug' => $slug]);


        if (!$post){
            throw new NotFoundHttpException("Pas d'articles trouvé");
        }

        return $this->render('post/details.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/post/random", name="post_random")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function randomPost(PostRepository $postRepository): Response
    {
        $post = $postRepository->postsRandomOrder();

        return $this->render('post/randompost.html.twig', [
            'post' => $post
        ]);
    }

}
