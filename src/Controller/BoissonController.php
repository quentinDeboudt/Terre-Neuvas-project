<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoissonController extends AbstractController
{
    #[Route('/boisson', name: 'app_boisson')]
    public function index(): Response
    {
        return $this->render('boisson/index.html.twig', [
            'controller_name' => 'BoissonController',
        ]);
    }
}
