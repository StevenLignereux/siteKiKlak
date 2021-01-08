<?php

namespace App\Controller;

use App\Form\SearchPostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchBarController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param PostRepository $postRepository
     * @param Request $request
     * @return Response
     */
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $post = $postRepository->findBy([], ['createdAt' => 'desc'], 12);

        $form = $this->createForm(SearchPostType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $post = $postRepository->search(
                $search->get('words')->getData(),
                $search->get('category')->getData()
            );
        }

        return $this->render('main/search.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }
}
