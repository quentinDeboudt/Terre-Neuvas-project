<?php

namespace App\Controller;


use App\Entity\Boisson;
use App\Form\BoissonType;

use App\Repository\BoissonRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/menu')]
class BoissonController extends AbstractController
{
    ///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newBoisson', name: 'Boisson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoissonRepository $BoissonRepository, FileUploader $fileUploader): Response
    {
        $boisson = new Boisson();
        $createBoissonform = $this->createForm(BoissonType::class, $boisson);
        $createBoissonform->handleRequest($request);

        if ($createBoissonform->isSubmitted() && $createBoissonform->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $createBoissonform->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $boisson->setBrochureFilename($brochureFileName);
            }

            $BoissonRepository->add($boisson, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Boisson/newBoisson.html.twig', [
            'boisson' => $boisson,
            'Boisson' => $createBoissonform->createView(),
        ]);
    }


    /////////////////////////////////////////...update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    #[Route('/{id}/editBoisson', name: 'menu_edit_Boisson', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boisson $boisson, BoissonRepository $boissonRepository, FileUploader $fileUploader): Response
    {
        $modifierBoissonForm = $this->createForm(BoissonType::class, $boisson);
        $modifierBoissonForm->handleRequest($request);

        if ($modifierBoissonForm->isSubmitted() && $modifierBoissonForm->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $modifierBoissonForm->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $boisson->setBrochureFilename($brochureFileName);
            }

            $boissonRepository->add($boisson, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        $brochure =$boisson->getBrochureFilename();
        $ID = $boisson->getId();
        return $this->render('Boisson/editBoisson.html.twig', [
            'ID'=>$ID,
            'brochure'=>$brochure,
            'boisson' => $boisson,
            'Boisson' => $modifierBoissonForm->createView(),
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
