<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

   

}