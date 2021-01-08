<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @var UserRepository
     */
    protected $user;
    /**
     * @var PostRepository
     */
    protected $post;
    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * DashboardController constructor.
     * @param PostRepository $post
     * @param CategoryRepository $category
     * @param UserRepository $user
     */
    public function __construct(PostRepository $post, CategoryRepository $category, UserRepository $user)
    {
        $this->post = $post;
        $this->user = $user;
        $this->category = $category;
    }

    /**
     * @Route("/admin", name="admin")
     * @Security ("is_granted('ROLE_ADMIN')")
     * @throws NonUniqueResultException
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllUsers' => $this->user->countAllUsers(),
            'countAllCategories' => $this->category->countAllCategories(),
            'posts' => $this->post->findAll(),
        ]);
    }

    /**
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SiteKiKlak');

    }

    /**
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Administration', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fas fa-clipboard', Post::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-newspaper', Category::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Evénements', 'fas fa-calendar', Event::class);
        yield MenuItem::linkToLogout('Retour au site', 'fas fa-arrow-circle-left');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            ->setGravatarEmail($user->getUsername())
            ->displayUserAvatar(true);
    }
}
