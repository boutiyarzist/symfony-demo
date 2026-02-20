<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Service\ImageStorageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/upload", name="image_upload")
     */
    public function upload(Request $request, EntityManagerInterface $em, ImageStorageService $storageService): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('file')->getData();
            $filename = $storageService->store($uploadedFile);

            $image->setFilename($filename);
            $image->setUploadedAt(new \DateTime());

            $em->persist($image);
            $em->flush();

            $this->addFlash('success', 'Image uploadée avec succès !');
            return $this->redirectToRoute('image_upload');
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}