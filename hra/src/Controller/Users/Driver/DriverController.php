<?php

namespace App\Controller\Users\Driver;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DriverController extends AbstractController
{
    /**
     * @Route("/driver", name="driverHome")
     */
    public function driverHome(): Response
    {
        return $this->render('Users/Driver/driverHome.html.twig');
    }
}
