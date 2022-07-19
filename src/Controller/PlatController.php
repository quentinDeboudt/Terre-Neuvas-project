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
    /////////////////////////////////////////...Plats...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editPlat', name: 'menu_edit_plat', methods: ['GET', 'POST'])]
    public function edit_plat(Request $request, Plat $plat, PlatRepository $platRepository): Response
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
}
