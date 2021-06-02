<?php

namespace App\Controller\Users\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="adminHome")
     */
    public function adminHome(): Response
    {
        return $this->render('HRA/Users/Admin/adminHome.html.twig');
    }
    
    /**
     * @Route("/admin/agenda", name="agenda")
     */
    public function agenda(): Response
    {
        return $this->render('HRA/Users/Admin/agenda.html.twig');
    }

    /**
     * @Route("/admin/statistiques", name="statistical")
     */
    public function statistical(): Response
    {
        return $this->render('HRA/Users/Admin/statisticals.html.twig');
    }
    
    /**
     * @Route("/admin/parametres", name="settings")
     */
    public function settings(): Response
    {
        return $this->render('HRA/Users/Admin/settings.html.twig');
    }
    
    /**
     * @Route("/admin/index", name="index")
     */
    public function index(): Response
    {
        return parent::index();
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('Bonjour,');
    }
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
