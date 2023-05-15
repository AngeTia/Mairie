<?php

namespace App\Controller\Admin;

use App\Entity\Mairie;
use App\Entity\Users;
use App\Entity\Folder;
use App\Entity\Planning;
use App\Entity\Reservation;
use App\Entity\CheckFolder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {                
        return parent::index();
        
    }
    #[Route('/admin/crud', name: 'crud')]
    public function home(): Response
    {                
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(MairieCrudController::class)->generateUrl();
        return $this->redirect($url);
    }



    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mairie');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', "home");
        yield MenuItem::linkToCrud('Mairie', 'fas fa-list', Mairie::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-list', Users::class);
        yield MenuItem::linkToCrud('Folder', 'fas fa-list', Folder::class);
        yield MenuItem::linkToCrud('Planning', 'fas fa-list', Planning::class);
        yield MenuItem::linkToCrud('Reservation', 'fas fa-list', Reservation::class);
        yield MenuItem::linkToCrud('CheckFolder', 'fas fa-list', CheckFolder::class);
        
    }
}
