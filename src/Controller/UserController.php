<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\EditProfileType;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('user/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route ("/profile/post/add", name="post_add")
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @param FlashyNotifier $flashyNotifier
     * @return Response
     */
    public function add(CategoryRepository $categoryRepository, Request $request, FlashyNotifier $flashyNotifier): Response
    {
        $categories = $categoryRepository->findAll();
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $flashyNotifier->success('Votre article a bien été posté');
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/post/add.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     * @param Request $request
     * @param FlashyNotifier $flashyNotifier
     * @param CategoryRepository $categoryRepository
     * @return RedirectResponse|Response
     */
    public function editProfile(Request $request, FlashyNotifier $flashyNotifier, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $flashyNotifier->warning('Votre profile a bien été mis à jour');
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/editprofile.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }
}
