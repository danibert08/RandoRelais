<?php

namespace App\Controller\Api;

use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("", name="api_service_list", methods={"GET"})
     */
    public function list(ServiceRepository $serviceRepository): Response
    {
        // We get all the users.
        $service = $serviceRepository->findAll();

        // We display the page with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->json($service, 200, [], [
            'groups' => 'services'
        ]);
    }

    /**
     * @Route("/{id}", name="api_service_details", methods={"GET"})
     */
    public function details(int $id, ServiceRepository $service): Response
    {
        // We get the user by is id.
        $service = $service->find($id);

        // If the user's status is 2 (Angel). We can display the data.
        // We display the data with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->json($service, 200, [], [
            'groups' => 'services'
        ]);
    }
}
