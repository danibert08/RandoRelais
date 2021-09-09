<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\AddressApi;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * 
     * Method to display all users
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * 
     * Method to create a user
     */
    public function new(Request $request, UserPasswordHasherInterface $UserPasswordHasherInterface, ImageUploader $imageUploader, AddressApi $addressApi): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // We hash the password when form is submitted
            $user->setPassword(
                $UserPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // We store the uploaded picture
            $newFileName = $imageUploader->imageUpload($form, 'picture');
            // We set the picture property with the uploaded picture
            $user->setpicture($newFileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            // use this service to get the coordinates for an angel
            $user = $addressApi->getCoordinatesWithAddress($user);

            $entityManager->flush();

            $this->addFlash('success', 'l\'utilisateur ' .$user->getFirstName(). ' ' .$user->getLastName(). ' a bien été créé');
            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * 
     * Method to display an user details
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * 
     * Method to edit a user
     */
    public function edit(Request $request, User $user, ImageUploader $imageUploader, AddressApi $addressApi): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $newFileName = $imageUploader->imageUpload($form, 'picture');
            if ($newFileName !== null) {

                $user->setpicture($newFileName);
            }

            // use this service to get the coordinates for an angel
            $user = $addressApi->getCoordinatesWithAddress($user);
            
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'utilisateur ' .$user->getFirstName(). ' ' .$user->getLastName(). ' a bien été modifié');
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     * 
     * Method to delete a user
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur supprimé');
            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return new Response('Action interdite', 403);
        }

    }
}
