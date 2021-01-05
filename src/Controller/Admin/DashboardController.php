<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     */
    public
    function index(): Response
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
    public
    function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SiteKiKlak');
    }

    /**
     * @return iterable
     */
    public
    function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
