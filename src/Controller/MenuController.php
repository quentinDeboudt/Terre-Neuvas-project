<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Plat;
use App\Form\EntreeType;
use App\Form\PlatType;
use App\Repository\BoissonRepository;
use App\Repository\DessertRepository;
use App\Repository\EntreeRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu', methods: ['GET'])]
    public function index(EntreeRepository $entreeRepository, PlatRepository $platRepository, DessertRepository $dessertRepository, BoissonRepository $boissonRepository): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_accueil');
        } else {
            return $this->render('menu/menu.html.twig', [
                'LstEntrees' => $entreeRepository->findAll(),
                'LstPLats' => $platRepository->findAll(),
                'LstDesserts' => $dessertRepository->findAll(),
                'LstBoissons' => $boissonRepository->findAll(),
                'controller_name' => 'MenuController',''
            ]);
        }
    }
}
