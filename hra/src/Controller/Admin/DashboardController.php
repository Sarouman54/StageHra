<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('HRA/Admin/adminHome.html.twig');
    }
    
    /**
     * @Route("/admin/agenda", name="agenda")
     */
    public function agenda(): Response
    {
        return $this->render('HRA/agenda.html.twig');
    }
    
    /**
     * @Route("/admin/activites", name="activite")
     */
    public function activite(): Response
    {
        return $this->render('HRA/activite.html.twig');
    }
    
    /**
     * @Route("/admin/personnels", name="personnels")
     */
    public function personnels(): Response
    {
        return $this->render('HRA/personnels.html.twig');
    }
    
    /**
     * @Route("/admin/organisation", name="organisation")
     */
    public function organisation(): Response
    {
        return $this->render('HRA/organisation.html.twig');
    }
    
    /**
     * @Route("/admin/localisation", name="localisation")
     */
    public function localisation(): Response
    {
        return $this->render('HRA/localisation.html.twig');
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
