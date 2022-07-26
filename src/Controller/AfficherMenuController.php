<?php

namespace App\Controller;

use App\Repository\BoissonRepository;
use App\Repository\DessertRepository;
use App\Repository\EntreeRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherMenuController extends AbstractController
{
    #[Route('/afficher/menu', name: 'app_afficher_menu')]
    public function index(EntreeRepository $entreeRepository, PlatRepository $platRepository, DessertRepository $dessertRepository, BoissonRepository $boissonRepository): Response
    {
        return $this->render('afficher_menu/afficherMenu.html.twig', [
            'LstEntrees' => $entreeRepository->findAll(),
            'LstPLats' => $platRepository->findAll(),
            'LstDesserts' => $dessertRepository->findAll(),
            'LstBoissons' => $boissonRepository->findAll(),
            'controller_name' => 'MenuController',''
        ]);
    }
}
