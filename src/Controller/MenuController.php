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




    /////////////////////////////////////////...Plats...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/edit', name: 'menu_edit_plat', methods: ['GET', 'POST'])]
    public function edit_plat(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        $modifierMenuForm = $this->createForm(PlatType::class, $plat);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $platRepository->add($plat, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'plat' => $plat,
            'form' => $modifierMenuForm->createView(),
        ]);
    }
}
