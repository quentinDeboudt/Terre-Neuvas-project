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
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu', methods: ['GET'])]
    public function index(EntreeRepository $entreeRepository, PlatRepository $platRepository, DessertRepository $dessertRepository, BoissonRepository $boissonRepository): Response
    {

        return $this->render('menu/menu.html.twig', [
            'LstEntrees' => $entreeRepository->findAll(),
            'LstPLats' => $platRepository->findAll(),
            'LstDessert' => $dessertRepository->findAll(),
            'LstBoisson' => $boissonRepository->findAll(),
            'controller_name' => 'MenuController',''
        ]);
    }
}
