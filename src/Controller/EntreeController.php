<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class EntreeController extends AbstractController
{


///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newEntree', name: 'Entree_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntreeRepository $entreeRepository, FileUploader $fileUploader): Response
    {
        $Entree = new Entree();
        $createEntreeform = $this->createForm(EntreeType::class, $Entree);
        $createEntreeform->handleRequest($request);

        if ($createEntreeform->isSubmitted() && $createEntreeform->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $createEntreeform->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $Entree->setBrochureFilename($brochureFileName);
            }

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
    public function edit(Request $request, Entree $Entree, EntreeRepository $entreeRepository, FileUploader $fileUploader): Response
    {

        $modifierMenuForm = $this->createForm(EntreeType::class, $Entree);
        $modifierMenuForm->handleRequest($request);

        if ($modifierMenuForm->isSubmitted() && $modifierMenuForm->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $modifierMenuForm->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $Entree->setBrochureFilename($brochureFileName);
            }

            $entreeRepository->add($Entree, true);

            $Entree = $modifierMenuForm->getData();

            $manager->persist($Entree);

            $manager->flush();

            $this->addFlash('success', 'Entrée à été modifié avec succès.');
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('entree/editEntree.html.twig', [
            'entree' => $Entree,
            'Entree' => $modifierMenuForm->createView(),
        ]);
    }


///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/Delete/{id}', name: 'Entree_delete', methods: ['POST'])]
    public function Delete(Request $request, Entree $entree, EntreeRepository $entreeRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {
            $entreeRepository->remove($entree, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }
}
