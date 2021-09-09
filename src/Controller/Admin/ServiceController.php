<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\User;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ImageUploader;

/**
 * @Route("/admin/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("", name="admin_service_index", methods={"GET"})
     */
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('admin/service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_service_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            
            $newFileName = $imageUploader->imageUpload($form, 'image');
            $service->setimage($newFileName);
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();
            $this->addFlash('success', 'Nouveau service  ajouté avec succès');
            return $this->redirectToRoute('admin_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_service_show", methods={"GET"})
     */
    public function show(Service $service): Response
    {
        return $this->render('admin/service/show.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_service_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Service $service, ImageUploader $imageUploader): Response
    {
        $form = $this->createForm(ServiceType::class, $service );
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $newFileName = $imageUploader->imageUpload($form, 'image');
            if ($newFileName !== null) {
            {        // On met à jour le chemin vers l'image en BDD
                $service->setImage($newFileName);
            }
        }
            $em= $this->getDoctrine()->getManager();

            $em->flush();
            $this->addFlash('success','Mise à jour du service effectuée');
            return $this->redirectToRoute('admin_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_service_delete", methods={"POST"})
     */
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
