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
    #[Route('/newBoisson', name: 'Boisson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoissonRepository $BoissonRepository): Response
    {
        $Boisson = new Boisson();
        $createBoissonform = $this->createForm(BoissonType::class, $Boisson);
        $createBoissonform->handleRequest($request);

        if ($createBoissonform->isSubmitted() && $createBoissonform->isValid()) {
            $BoissonRepository->add($Boisson, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Boisson/newBoisson.html.twig', [
            'boisson' => $Boisson,
            'Boisson' => $createBoissonform->createView(),
        ]);
    }


    /////////////////////////////////////////...update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editBoisson', name: 'menu_edit_Boisson', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boisson $boisson, BoissonRepository $boissonRepository): Response
    {
        $modifierMenuForm = $this->createForm(BoissonType::class, $boisson);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $boissonRepository->add($boisson, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Boisson/editBoisson.html.twig', [
            'boisson' => $boisson,
            'Boisson' => $modifierMenuForm->createView(),
        ]);
    }

    ///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/Delete/{id}', name: 'Boisson_delete', methods: ['POST'])]
    public function delete(Request $request, Boisson $boisson, BoissonRepository $boissonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boisson->getId(), $request->request->get('_token'))) {
            $boissonRepository->remove($boisson, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }

}
