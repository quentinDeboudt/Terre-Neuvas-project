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
use function PHPUnit\Framework\fileExists;

#[Route('/menu')]
class EntreeController extends AbstractController
{


///////////////////////////////////////////////...Create...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/newEntree', name: 'Entree_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntreeRepository $entreeRepository, FileUploader $fileUploader): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_accueil');
        } else {
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
    }


///////////////////////////////////////////////...Update...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}/editEntree', name: 'menu_edit_entree', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entree $Entree, EntreeRepository $entreeRepository, FileUploader $fileUploader): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_accueil');
        } else {
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
                $this->addFlash('success', 'Entrée à été modifié avec succès.');
                return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
            }
            $brochure =$Entree->getBrochureFilename();
            $ID = $Entree->getId();
            return $this->render('entree/editEntree.html.twig', [
                'ID'=>$ID,
                'brochure'=>$brochure,
                'entree' => $Entree,
                'Entree' => $modifierMenuForm->createView(),
            ]);
        }
    }


///////////////////////////////////////////////...Delete...\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    #[Route('/{id}/DeleteEntree', name: 'Entree_delete', methods: ['POST'])]
    public function Delete(Request $request, Entree $entree, EntreeRepository $entreeRepository, FileUploader $fileUploader): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_accueil');
        } else {
            if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {
                $entreeRepository->remove($entree, true);

                $brochureFile = $entree->getBrochureFilename();
                $brochureFile->remove(
                    $this->getParameter("brochures_directory"), $this->getParameter("brochures_directory"). '/' . $brochureFile
                );


//                //##########image##################
//                $brochureFile = $entree->getBrochureFilename();
//                if ($brochureFile){
//                    $brochureFileName = $this->getParameter("brochures_directory"). '/' . $brochureFile;
//
//                    if (fileExists($brochureFileName)){
//                        unlink($brochureFile);
//                    }
//                }
            }
            return $this->redirectToRoute('app_menu', [], Response::HTTP_SEE_OTHER);
        }
    }
}
