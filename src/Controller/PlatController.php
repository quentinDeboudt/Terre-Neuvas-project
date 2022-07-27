<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class PlatController extends AbstractController
{
    //////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newPlat', name: 'Plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $PlateRepository, FileUploader $fileUploader): Response
    {
        $Plat = new Plat();
        $createPlatform = $this->createForm(PlatType::class, $Plat);
        $createPlatform->handleRequest($request);

        if ($createPlatform->isSubmitted() && $createPlatform->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $createPlatform->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $Plat->setBrochureFilename($brochureFileName);
            }

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
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository, FileUploader $fileUploader): Response
    {
        $modifierPlatForm = $this->createForm(PlatType::class, $plat);
        $modifierPlatForm->handleRequest($request);

        if ($modifierPlatForm->isSubmitted() && $modifierPlatForm->isValid()) {

            //################# image ###################\\
            /** @var UploadedFile $brochureFile */
            $brochureFile = $modifierPlatForm->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $plat->setBrochureFilename($brochureFileName);
            }

            $platRepository->add($plat, true);
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }

        $brochure =$plat->getBrochureFilename();
        $ID = $plat->getId();
        return $this->render('plat/editPlat.html.twig', [
            'brochure'=>$brochure,
            'plat' => $plat,
            'Plat' => $modifierPlatForm->createView(),
            'ID'=>$ID,
        ]);
    }

    ///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/Delete/{id}', name: 'Plat_delete', methods: ['post'])]
    public function delete(Request $request, Plat $plat, PlatRepository $PlatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $PlatRepository->remove($plat, true);
        }
        return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
    }

}
