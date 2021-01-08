<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\PostType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('user/index.html.twig');
    }

    /**
     * @Route ("/profile/post/add", name="post_add")
     * @param Request $request
     * @param FlashyNotifier $flashyNotifier
     * @return Response
     */
    public function add(Request $request, FlashyNotifier $flashyNotifier): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User|object|null $this
             */
            $post->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $flashyNotifier->success('Votre article a bien été posté');
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/profile/edit", name="profile_edit")
     * @param Request $request
     * @param FlashyNotifier $flashyNotifier
     * @return RedirectResponse|Response
     */
    public function editProfile(Request $request, FlashyNotifier $flashyNotifier)
    {
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
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/profile/changepassword", name="profile_change_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FlashyNotifier $flashyNotifier
     * @return RedirectResponse|Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, FlashyNotifier $flashyNotifier)
    {
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            if ($request->get('pass') == $request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $flashyNotifier->success('Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('profile');

            } else {
                $flashyNotifier->error('Erreur les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/changePassword.html.twig');
    }
}
