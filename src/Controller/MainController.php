<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use App\Repository\PostRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
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
     * @param Request $request
     * @param MailerInterface $mailer
     * @param User $user
     * @return Response
     */
    public function contact(Request $request, MailerInterface $mailer, User $user): Response
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($user->getEmail());
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
