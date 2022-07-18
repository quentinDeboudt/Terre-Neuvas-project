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


    /////////////////////////////////////////...Entree...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}/edit', name: 'menu_edit_entree', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entree $entree, EntreeRepository $entreeRepository): Response
    {
        $modifierMenuForm = $this->createForm(EntreeType::class, $entree);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $entreeRepository->add($entree, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'entree' => $entree,
            'form' => $modifierMenuForm->createView(),
        ]);
    }

    #[Route('/new', name: 'Entree_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntreeRepository $entreeRepository): Response
    {
        $Entree = new Entree();
        $createEntreeform = $this->createForm(EntreeType::class, $Entree);
        $createEntreeform->handleRequest($request);

        if ($createEntreeform->isSubmitted() && $createEntreeform->isValid()) {
            $createEntreeform->add( $Entree, true);

            return $this->redirectToRoute('menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'entree' => $Entree,
            'form' => $createEntreeform->createView(),
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
