<?php

namespace Admin\Controller;

use Admin\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ROLE_ADMIN->value);

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pontos de Coleta')
            ->setFaviconPath('favicon.svg')
            //->renderContentMaximized()
            //->renderSidebarMinimized()
            //->disableDarkMode()
            ->generateRelativeUrls()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    }
}
