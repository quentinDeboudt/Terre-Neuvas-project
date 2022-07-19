<?php

namespace App\Controller;

use App\Entity\Boisson;
use App\Form\BoissonType;
use App\Repository\BoissonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/menu')]
class BoissonController extends AbstractController
{
    ///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/new', name: 'Boisson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoissonRepository $BoissonRepository): Response
    {
        $Boisson = new Boisson();
        $createDessertform = $this->createForm(BoissonType::class, $Boisson);
        $createDessertform->handleRequest($request);

        if ($createDessertform->isSubmitted() && $createDessertform->isValid()) {
            $BoissonRepository->add($Boisson, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Boisson/newBoisson.html.twig', [
            'boisson' => $Boisson,
            'Boisson' => $createDessertform->createView(),
        ]);
    }


    /////////////////////////////////////////...update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editBoisson', name: 'menu_edit_Boisson', methods: ['GET', 'POST'])]
    public function edit_plat(Request $request, Boisson $Boisson, BoissonRepository $BoissonRepository): Response
    {
        $modifierMenuForm = $this->createForm(BoissonType::class, $Boisson);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $BoissonRepository->add($Boisson, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Boisson/editBoisson.html.twig', [
            'boisson' => $Boisson,
            'Boisson' => $modifierMenuForm->createView(),
        ]);
    }
}
