<?php

namespace App\Controller\Admin;

use App\Repository\ReviewRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/admin", name="admin_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="stat")
     */
    public function index(UserRepository $user, ReviewRepository $review, ServiceRepository $service, SerializerInterface $serializer): Response
    {
        /* Counting of All registrants */
        $registeredUsersList = $user->findAll();
        $usersQuantity = count($registeredUsersList);

        /* counting of all registrants by their status and if registrant's status is angel, define and counting his offered services*/
        $desactived = 0;
        $walker = 0;
        $angel = 0;
        $services = $service->findAll();
        $angels = $user->findAngelAndServices(2);

        foreach ($services as $service) {
            $arrayResult[$service->getName()] = 0;
        }

        foreach ($registeredUsersList as $user) {
            if ($user->getStatus() === 2) {
                $angel++;
                foreach ($user->getServices() as $service) {
                    /* Check if service is offered by angel, and if yes, add one more in the array popularity of services for this service */
                   
                        $arrayResult[$service->getName()]++;
                   
                }
            } else if ($user->getStatus() === 1) {
                $walker++;
            } else {
                $desactived++;
            }
        }

        $reviewList = $review->findAll();
        $reviewQuantity = count($reviewList);
        $reviewQuantityMonth = count($review->findByDate(-30));

        return $this->render('admin/main/stat.html.twig', [

            'registeredUsersList' => $registeredUsersList,
            'usersQuantity' => $usersQuantity,
            'desactived' => $desactived,
            'walker' => $walker,
            'angel' => $angel,
            'reviewQuantity' => $reviewQuantity,
            'reviewQuantityMonth' => $reviewQuantityMonth,
            'serviceList' => $arrayResult,
            'services' => $services
        ]);
    }
}
