<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HraController extends AbstractController
{
    #[Route('/hra', name: 'hra')]
    public function index(): Response
    {
        return $this->render('HRA/index.html.twig', [
            'controller_name' => 'HraController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('HRA/home.html.twig');
    }

    #[Route('/admin/agenda', name: 'agenda')]
    public function agenda(): Response
    {
        return $this->render('HRA/agenda.html.twig');
    }

    #[Route('/statistiques', name: 'statistiques')]
    public function statistical(): Response
    {
        return $this->render('HRA/statistical.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('HRA/contact.html.twig');
    }

    #[Route('/truc', name: 'administrateur')]
    public function administrator(): Response
    {
        return $this->render('HRA/Admin/adminHome.html.twig');
    }
}