<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController extends AbstractController
{
    #[Route('/entree', name: 'app_entree')]
    public function index(): Response
    {
        return $this->render('entree/index.html.twig', [
            'controller_name' => 'EntreeController',
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
            $createEntreeform->add($request);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'entree' => $Entree,
            'form' => $createEntreeform->createView(),
        ]);
    }

}
