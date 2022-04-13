<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\DashboardMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SubMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {}

    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(FormationCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECOWEB ADMINISTRATION');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getEmail());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('ADMINISTRATEUR')
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Formateurs', 'fas fa-user', UserCrudController::getEntityFqcn())
            ->setPermission('ROLE_ADMIN');

        yield MenuItem::section('FORMATEUR')
            ->setPermission('ROLE_TEACHER');
        yield MenuItem::linkToCrud('Formations', 'fas fa-book', FormationCrudController::getEntityFqcn())
            ->setPermission('ROLE_TEACHER');
        yield MenuItem::linkToCrud('Sections', 'fas fa-book', SectionCrudController::getEntityFqcn())
            ->setPermission('ROLE_TEACHER');
        yield MenuItem::linkToCrud('Leçons', 'fas fa-book', LessonCrudController::getEntityFqcn())
            ->setPermission('ROLE_TEACHER');
        yield MenuItem::section('RETOUR');
        yield MenuItem::linktoRoute('Retour au site', 'fas fa-home', 'home');
    }
}
