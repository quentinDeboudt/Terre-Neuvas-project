<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class EntreeController extends AbstractController
{


///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newEntree', name: 'Entree_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntreeRepository $entreeRepository): Response
    {
        $Entree = new Entree();
        $createEntreeform = $this->createForm(EntreeType::class, $Entree);
        $createEntreeform->handleRequest($request);

        if ($createEntreeform->isSubmitted() && $createEntreeform->isValid()) {
            $entreeRepository->add($Entree, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('entree/newEntree.html.twig', [
            'entree' => $Entree,
            'Entree' => $createEntreeform->createView(),
        ]);
    }


///////////////////////////////////////////////...Update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}/editEntree', name: 'menu_edit_entree', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entree $entree, EntreeRepository $entreeRepository): Response
    {
        $modifierMenuForm = $this->createForm(EntreeType::class, $entree);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {
            $entreeRepository->add($entree, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entree/editEntree.html.twig', [
            'entree' => $entree,
            'Entree' => $modifierMenuForm->createView(),
        ]);
    }


///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}', name: 'Entree_delete', methods: ['POST'])]
    public function delete(Request $request, Entree $entree, EntreeRepository $entreeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {
            $entreeRepository->remove($entree, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }
}
