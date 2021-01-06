<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $post = $postRepository->findAllLatest();
        $categories = $categoryRepository->findAll();

        return $this->render('main/index.html.twig', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * @Route ("/about", name="app_about")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function about(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('main/about.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/team", name="app_team")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function team(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('main/team.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route ("/contact", name="app_contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @param FlashyNotifier $flashy
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer, FlashyNotifier $flashy, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@klak.fr')
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'name' => $contact->get('name')->getData(),
                    'firstname' => $contact->get('firstname')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $flashy->success('Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }


}
