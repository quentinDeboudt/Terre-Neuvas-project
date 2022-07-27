<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Form\DessertType;
use App\Repository\DessertRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class DessertController extends AbstractController
{

///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newDessert', name: 'Dessert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DessertRepository $DessertRepository, FileUploader $fileUploader): Response
    {
        $Dessert = new Dessert();
        $createDessertform = $this->createForm(DessertType::class, $Dessert);
        $createDessertform->handleRequest($request);

        if ($createDessertform->isSubmitted() && $createDessertform->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $createDessertform->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $Dessert->setBrochureFilename($brochureFileName);
            }

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
    public function edit(Request $request, Dessert $Dessert, DessertRepository $DessertRepository, FileUploader $fileUploader): Response
    {
        $modifierDessertForm = $this->createForm(DessertType::class, $Dessert);
        $modifierDessertForm->handleRequest($request);

        if ($modifierDessertForm->isSubmitted() && $modifierDessertForm->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $modifierDessertForm->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $Dessert->setBrochureFilename($brochureFileName);
            }

            $DessertRepository->add($Dessert, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
        $brochure =$Dessert->getBrochureFilename();

        return $this->render('Dessert/editDessert.html.twig', [
            'brochure'=>$brochure,
            'dessert' => $Dessert,
            'Dessert' => $modifierDessertForm->createView(),
        ]);
    }

    ///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/Delete/{id}', name: 'Dessert_delete', methods: ['POST'])]
    public function delete(Request $request, Dessert $Dessert, DessertRepository $DessertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Dessert->getId(), $request->request->get('_token'))) {
            $DessertRepository->remove($Dessert, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }
}
