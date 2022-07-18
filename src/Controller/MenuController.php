<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu', methods: ['GET'])]
    public function index(EntreeRepository $entreeRepository): Response
    {

        return $this->render('menu/menu.html.twig', [
            'LstEntrees' => $entreeRepository->findAll(),
            'controller_name' => 'MenuController',''
        ]);
    }


    #[Route('/{id}/edit', name: 'menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entree $entree, EntreeRepository $entreeRepository): Response
    {
        $modifierMenuForm = $this->createForm(EntreeType::class, $entree);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $entreeRepository->add($entree, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'ville' => $entree,
            'form' => $modifierMenuForm->createView(),
        ]);
    }

}
