<?php

namespace App\Controller\Users\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Data;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="adminHome")
     */
    public function adminHome(): Response
    {
        return $this->render('Users/Admin/adminHome.html.twig');
    }

    /**
     * @Route("/driver", name="driverHome")
     */
    public function driverHome(): Response
    {
        return $this->render('Users/Driver/driverHome.html.twig');
    }
    
    /**
     * @Route("/admin/agenda", name="agenda")
     */
    public function agenda(): Response
    {
        return $this->render('Users/Admin/agenda.html.twig');
    }
    
    /**
     * @Route("/admin/activites", name="activities")
     */
    public function activities(): Response
    {
        return $this->render('Users/Admin/activities.html.twig');
    }
    
    /**
     * @Route("/admin/personnels", name="staff")
     */
    public function staff(): Response
    {
        return $this->render('Users/Admin/staff.html.twig');
    }
    
    /**
     * @Route("/admin/organisation", name="organization")
     */
    public function organization(): Response
    {
        return $this->render('Users/Admin/organization.html.twig');
    }
    
    /**
     * @Route("/admin/localisation", name="localisation")
     */
    public function localisation(): Response
    {
        return $this->render('Users/Admin/localisation.html.twig');
    }
    
    /**
     * @Route("/admin/statistiques", name="statistical")
     */
    public function statistiques(): Response
    {
        return $this->render('Users/Admin/statisticals.html.twig');
    }
    
    /**
     * @Route("/admin/parametres", name="settings")
     */
    public function parametres(): Response
    {
        return $this->render('Users/Admin/settings.html.twig');
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
