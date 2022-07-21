<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class PlatController extends AbstractController
{
    //////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newPlat', name: 'Plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $PlateRepository): Response
    {
        $Plat = new Plat();
        $createPlatform = $this->createForm(PlatType::class, $Plat);
        $createPlatform->handleRequest($request);

        if ($createPlatform->isSubmitted() && $createPlatform->isValid()) {
            $PlateRepository->add($Plat, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Plat/newPlat.html.twig', [
            'plat' => $Plat,
            'Plat' => $createPlatform->createView(),
        ]);
    }


    /////////////////////////////////////////...update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editPlat', name: 'menu_edit_plat', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        $modifierMenuForm = $this->createForm(PlatType::class, $plat);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $platRepository->add($plat, true);

            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plat/editPlat.html.twig', [
            'plat' => $plat,
            'Plat' => $modifierMenuForm->createView(),
        ]);
    }

    ///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}', name: 'Plat_delete', methods: ['POST'])]
    public function delete(Request $request, Plat $plat, PlatRepository $PlatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $PlatRepository->remove($plat, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }

}
