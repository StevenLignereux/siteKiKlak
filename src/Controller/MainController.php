<?php

namespace App\Controller;

use App\Form\ContactType;
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
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $limit = 3;

        $page = (int)$request->query->get('page', '1');

        $post = $postRepository->getPaginatedPost($page, $limit);

        $total = $postRepository->getTotalPost();

        return $this->render('main/index.html.twig', compact('post', 'total', 'limit', 'page'));
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
     * @param FlashyNotifier $flashy
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer, FlashyNotifier $flashy): Response
    {

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
        ]);
    }


}
