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

    #[Route('/agenda', name: 'agenda')]
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

    #[Route('/connexion', name: 'connexion')]
    public function connection(): Response
    {
      return $this->render('HRA/connection.html.twig');
            
    }

    #[Route('/inscription', name: 'inscription')]
    public function registration(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $utilisateur = new Utilisateur();

        $form = $this->createFormBuilder($utilisateur)
                    ->add('nom')
                    ->add('prenom')
                    ->add('mail')
                    ->add('mdp')
                    ->add('profils')
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('home', ['id' => $article->getId()]);

        }

        return $this->render('HRA/registration.html.twig', [
            'formUtilisateur'=> $form->createView()
        ]);

    }

    #[Route('/administrateur', name: 'administrateur')]
    public function administrator(): Response
    {
        return $this->render('HRA/Administrator/administrator.html.twig');
    }

    #[Route('/administrateur/organisation', name: 'organisation')]
    public function organisation(): Response
    {
        return $this->render('HRA/Administrator/organisation.html.twig');
    }

    #[Route('/administrateur/localisation', name: 'localisation')]
    public function localisation(): Response
    {
        return $this->render('HRA/Administrator/localisation.html.twig');
    }

    #[Route('/administrateur/sequences', name: 'sequences')]
    public function sequences(): Response
    {
        return $this->render('HRA/Administrator/sequences.html.twig');
    }
}