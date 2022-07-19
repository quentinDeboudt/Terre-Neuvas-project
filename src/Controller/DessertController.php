<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Form\DessertType;
use App\Repository\DessertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class DessertController extends AbstractController
{

    /////////////////////////////////////////...Dessrt...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editDessert', name: 'menu_edit_Dessert', methods: ['GET', 'POST'])]
    public function edit_plat(Request $request, Dessert $Dessert, DessertRepository $DessertRepository): Response
    {
        $modifierMenuForm = $this->createForm(DessertType::class, $Dessert);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $DessertRepository->add($Dessert, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plat/editDessert.html.twig', [
            'dessert' => $Dessert,
            'Dessert' => $modifierMenuForm->createView(),
        ]);
    }
}
