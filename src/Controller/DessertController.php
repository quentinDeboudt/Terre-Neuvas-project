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

///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newDessert', name: 'Dessert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DessertRepository $DessertRepository): Response
    {
        $Dessert = new Dessert();
        $createDessertform = $this->createForm(DessertType::class, $Dessert);
        $createDessertform->handleRequest($request);

        if ($createDessertform->isSubmitted() && $createDessertform->isValid()) {
            $DessertRepository->add($Dessert, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Dessert/newDessert.html.twig', [
            'dessert' => $Dessert,
            'Dessert' => $createDessertform->createView(),
        ]);
    }

    /////////////////////////////////////////...Update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editDessert', name: 'menu_edit_Dessert', methods: ['GET', 'POST'])]
    public function edit_plat(Request $request, Dessert $Dessert, DessertRepository $DessertRepository): Response
    {
        $modifierMenuForm = $this->createForm(DessertType::class, $Dessert);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $DessertRepository->add($Dessert, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Dessert/editDessert.html.twig', [
            'dessert' => $Dessert,
            'Dessert' => $modifierMenuForm->createView(),
        ]);
    }

    ///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}', name: 'Dessert_delete', methods: ['POST'])]
    public function delete(Request $request, Dessert $Dessert, DessertRepository $DessertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Dessert->getId(), $request->request->get('_token'))) {
            $DessertRepository->remove($Dessert, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }
}
