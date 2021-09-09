<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/angel")
 */
class AngelController extends AbstractController
{
    /**
     * @Route("", name="api_angel_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): Response
    {
        // We get all the users with the status 2 => angel and the services they offer.
        $angels = $userRepository->findAngelAndServices(2);

        // We display the page with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->json($angels, 200, [], [
            'groups' => 'users'
        ]);
    }

    /**
     * @Route("/{id}/information", name="api_angel_details", methods={"GET"})
     */
    public function details(int $id, UserRepository $userRepository): Response
    {
        // We get the user by is id.
        $user = $userRepository->find($id);

        // If the user's status is User::ANGEL_STATUS.
        if ($user->getStatus() === User::ANGEL_STATUS) {
            // We display the data with a array of optional data.
            // We specify the related HTTP response status code.
            return $this->json($user, 200, [], [
                'groups' => 'users'
            ]);
        } // Else the user have a User::HIKER_STATUS or a User::ROLE_DEACTIVATE.
        else {
            // We can't display the data because the status 1 (Marcheur) don't have a information page.
            // We display a flash message for the user.
            // We specify the related HTTP response status code.
            return $this->json([
                'message' => 'Un utilisateur marcheur ou désactivé ne possède pas de page information.'
            ], 404);
        }

        // ! START DON'T TOUCH.
        // TODO START : try with User::ROLE_DEACTIVATE.
        // // If the user's status is User::ANGEL_STATUS and if the user's role is different than User::ROLE_DEACTIVATE.
        // if ($user->getStatus() === User::ANGEL_STATUS && $user->getRoles() != User::ROLE_DEACTIVATE) {
        //     // We display the data with a array of optional data.
        //     // We specify the related HTTP response status code.
        //     return $this->json($user, 200, [], [
        //         'groups' => 'users'
        //     ]);
        // } // Else the user have a User::HIKER_STATUS or have a  User::ROLE_DEACTIVATE.
        // else {
        //     // We can't display the data because of the user's role.
        //     // We display a flash message for the user.
        //     // We specify the related HTTP response status code.
        //     return $this->json([
        //         'message' => 'Un utilisateur marcheur ou désactivé ne possède pas de page information.'
        //     ], 404);
        // }
        // TODO END.
        // ! END.
    }

    /**
    * @Route("/recherche", name="api_angel_search", methods={"GET"})
    */
    public function search(Request $request, UserRepository $userRepository, ServiceRepository $serviceRepository): Response
    {
        // TODO START.
        // We display the data with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->json([], 200);
        // TODO END.
    }
}
