<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use App\Service\WeatherApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/info/{id}", name="show_angel", requirements={"id" = "\d+"})
     */
    public function showAngel(int $id, UserRepository $userRepository, WeatherApi $weatherApi): Response
    {
        // Get the data of the specific angel called in the route ({id)}) in database
        $angelData = $userRepository->find($id);

        // Get the reviews from a user
        $userReviews = $angelData->getReviews();

        // Get the total number of reviews for this user
        $totalReviewsCount = count($userReviews);

        // Set the total rating to 0
        $totalRating = 0;
        $averageRating = 0;
        $authorNameArray[] = '';

        // Review: Calculate the average rating of the user and get the firstname of the author
        foreach ($userReviews as $currentReview) {
            // Get the rating of the current review
            $currentRating = $currentReview->getRating();
            // Calculate the total rating of the current review
            $totalRating = $totalRating + $currentRating;
            // Get the author's id of the current review
            $currentAuthorId = $currentReview->getAuthorId();

            // If there is a authorId in this review
            if ($currentAuthorId !== 0) {
                // Get the Author's object of a review
                $currentAuthor = $userRepository->find($currentAuthorId);
                // Get the name of the current author's id
                if ($currentAuthor !== null) {
                    // Get the firstName of the Author
                    $currentAuthorName = $currentAuthor->getFirstName();
                    // Fill an array with all the authors of the reviews
                    $authorNameArray[] = $currentAuthorName;
                }
            }
        }

        // Calculate the average rating of all reviews
        if ($totalReviewsCount !== 0) {
            $averageRating = $totalRating / $totalReviewsCount;
        }

        // Get user zipCode to use it for weatherApi service
        $zipCode = $angelData->getZipCode();
        $weather = $weatherApi->getWeather($zipCode);

        // Return the angel data to the view
        return $this->render('user/show-angel.html.twig', [
            'angelData' => $angelData,
            'userReviews' => $userReviews,
            'averageRating' => $averageRating,
            'totalReviewsCount' => $totalReviewsCount,
            'authorNameArray' => $authorNameArray,
            'weather' => $weather
        ]);
    }

    /**
     * @Route("/{id}/profil", name="user_profile", methods={"GET|POST"})
     */
    public function profile(Request $request, User $user, ImageUploader $imageIploader): Response
    {
        // We get the picture of the user.
        // $userPicture = $this->getUser()->getPicture();

        // We create the form.
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        // If the form is submitted & if the form is valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // If the form field picture has data.
            $newFileName = $imageIploader->imageUpload($form, 'upload');
            // If $newFileName === true.
            if ($newFileName) {
                // We set the picture property with the $newFileName.
                $user->setPicture($newFileName);
            } else {
                // We set the picture with the initial picture.
                $user->setPicture($this->getUser()->getPicture());
                // $user->setPicture($userPicture);
                // $this->getUser()->setPicture($userPicture);
            }

            // We call the getManager() method.
            $entityManager = $this->getDoctrine()->getManager();
            // We backup the data in the database.
            $entityManager->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Bonjour ' . $user->getFirstName() . ', votre profil a bien été modifié.');

            // We redirect the user to the profile page with a array of optional data.
            // We specify the related HTTP response status code.
            return $this->redirectToRoute('user_profile', ['id' => $user->getId()], 301);
        }

        // We display the page we want with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->render('user/profile.html.twig', [
            'UserProfileForm' => $form->createView(),
            'status' => $user->getStatusName(),
        ], new Response('', 200));
    }

    /**
     * @Route("/{id}/supprimer/photo", name="user_delete_picture", methods={"GET|POST"})
     */
    public function deleteProfilePicture(Request $request, User $user): Response
    {
        // We catch the csrfToken that the user submit after his click on the delete button.
        $submitedToken = $request->request->get('token') ??  $request->query->get('token');

        // If the submitedToken is valid.
        if ($this->isCsrfTokenValid('user-delete-picture' . $user->getId(), $submitedToken)) {
            // We set to picture the value of User::PROFILE_PICTURE_BY_DEFAULT.
            $user->setPicture(User::PROFILE_PICTURE_BY_DEFAULT);
            // We call the getManager() method.
            $entityManager = $this->getDoctrine()->getManager();
            // We backup the data in the database.
            $entityManager->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Bonjour ' . $user->getFirstName() . ', votre photo a bien été supprimée.');

            // We redirect the user to the profile page with a array of optional data.
            // We specify the related HTTP response status code.
            return $this->redirectToRoute('user_profile', ['id' => $user->getId()], 301);
        } // Else, the submitedToken is not valid.
        else {
            // We redirect the user to the page 403.
            // We specify the related HTTP response status code.
            return new Response('Action interdite', 403);
        }
    }

    /**
    * @Route("/{id}/supprimer", name="user_deactivate", methods={"PATCH"})
    */
    public function deactivateUserAccount(Request $request, User $user): Response
    {
        // We catch the Token that the user submit after his click on the delete button.
        $submitedToken = $request->request->get('token') ??  $request->query->get('token');

        // ! START DON'T TOUCH : code working with User::ROLE_DEACTIVATE
        // // If the submitedToken is valid.
        // if ($this->isCsrfTokenValid('user-deactivate' . $user->getId(), $submitedToken)) {
        //     // If the role of the current user different than User::ROLE_DEACTIVATE.
        //     if ($user->getRoles() != User::ROLE_DEACTIVATE) {
        //         // We set the role with the value of User::ROLE_DEACTIVATE.
        //         $user->setRoles(User::ROLE_DEACTIVATE);
        //         // We call the getManager() method.
        //         // We backup the data in the database.
        //         $this->getDoctrine()->getManager()->flush();
        //     }
 
        //     // TODO START : flash message not working.
        //     // // We display a flash message for the user.
        //     // $this->addFlash('success', 'Bonjour ' .$user->getFirstName(). ', votre compte est désactivé et sera prochainement supprimé.');
        //     // TODO END.
 
        //     // We redirect the user to the logout page with a array of optional data.
        //     // We specify the related HTTP response status code.
        //     return $this->redirectToRoute('app_logout', [], 301);
        // } // Else, somebody try to hack us.
        // else {
        //     // We redirect the user to the page 403.
        //     // We specify the related HTTP response status code.
        //     return new Response('Action interdite', 403);
        // }
        // ! END.

        // ! START DON'T TOUCH : Code working with User::DEACTIVATE_STATUS.
        // If the submitedToken is valid.
        if ($this->isCsrfTokenValid('user-deactivate' . $user->getId(), $submitedToken)) {
            // If the status of the current user different than User::DEACTIVATE_STATUS.
            if ($user->getStatus() != User::DEACTIVATE_STATUS) {
                // We set the status with the value of User::DEACTIVATE_STATUS.
                $user->setStatus(User::DEACTIVATE_STATUS);
                // We call the getManager() method.
                // We backup the data in the database.
                $this->getDoctrine()->getManager()->flush();
            }

            // TODO START : flash message not working.
            // // We display a flash message for the user.
            // $this->addFlash('success', 'Bonjour ' .$user->getFirstName(). ', votre compte est désactivé et sera prochainement supprimé.');
            // TODO END.

            // We redirect the user to the logout page with a array of optional data.
            // We specify the related HTTP response status code.
            return $this->redirectToRoute('app_logout', [], 301);
        } // Else, somebody try to hack us.
        else {
            // We redirect the user to the page 403.
            // We specify the related HTTP response status code.
            return new Response('Action interdite', 403);
        }
        // ! END.

        // ! START DON'T TOUCH.  code working for delete in database.
        // // If the submitedToken is valid.
        // if ($this->isCsrfTokenValid('delete-user' .$user->getId(), $submitedToken)) {
        //     // We call the getManager() method.
        //     $entityManager = $this->getDoctrine()->getManager();
        //     // We remove the user.
        //     $entityManager->remove($user);
        //     // We backup the data in the database.
        //     $entityManager->flush();

        //     // TODO START : flash message not working.
        //     // We display a flash message for the user.
        //     $this->addFlash('success', 'Le compte de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été supprimé.');
        //     // TODO END.

        //     // We redirect to user to the logout page page so he his logout & we specify the related HTTP response status code.
        //     return $this->redirectToRoute('app_logout', [], 301);
        // } // Else, the submitedToken is not valid.
        // else {
        //     // We redirect the user to the page 403.
        //     // We specify the related HTTP response status code.
        //     return new Response('Action interdite', 403);
        // }
        // ! END.
    }

    /**
     * @Route("/{id}/reactiver-mon-compte", name="user_allow_account_reactivation", methods={"GET"})
     *
     * @return Response
     */
    public function allowAccountReactivation(): Response
    {
        // We display the page we want with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->render(
            'user/reactivate-account.html.twig',
            [],
            new Response('', 200)
        );
    }

    /**
     * @Route("/{id}/reactivation", name="user_reactivate_account", methods={"PATCH"})
     *
     * @return Response
     */
    public function reactivateUserAccount(Request $request, User $user): Response
    {
        // We catch the Token that the user submit after his click on the delete button.
        $submitedToken = $request->request->get('token') ??  $request->query->get('token');

        // ! START DON'T TOUCH : code working with User::DEACTIVATE_STATUS.
        if ($this->isCsrfTokenValid('reactivate-user-account' . $user->getId(), $submitedToken)) {
            // If the status of the current user is User::DEACTIVATE_STATUS.
            if ($user->getStatus() === User::DEACTIVATE_STATUS) {
                // We set the status with the value of User::HIKER_STATUS.
                $user->setStatus(User::HIKER_STATUS);
                // We call the getManager() method.
                // We backup the data in the database.
                $this->getDoctrine()->getManager()->flush();
            }

            // We display a flash message for the user.
            $this->addFlash('success', 'Bonjour ' .$user->getFirstName(). ', votre compte a bien été réactivé.');
           
            // We redirect the user to the profile page with a array of optional data.
            // We specify the related HTTP response status code.
            return $this->redirectToRoute('user_profile', ['id' => $user->getId() ], 301);
        }  // Else, somebody try to hack us.
        else {
            // We redirect the user to the page 403.
            // We specify the related HTTP response status code.
            return new Response('Action interdite', 403);
        }
        // ! END.

        // ! START DON'T TOUCH.
        // TODO START : try with User::ROLE_DEACTIVATE.
        // // If the submitedToken is valid.
        // if ($this->isCsrfTokenValid('user_reactivate_account' . $user->getId(), $submitedToken)) {
        //     // // If the role of the current user is User::ROLE_DEACTIVATE.
        //     // if ($this->isGranted("ROLE_DEACTIVATE")) {
        //     //     // We set the role with the value of User::ROLE_USER.
        //     //     $user->setRoles(User::ROLE_USER);
        //     //     // We call the getManager() method.
        //     //     // We backup the data in the database.
        //     //     $this->getDoctrine()->getManager()->flush();
        //     // }

        //     // If the role of the current user is User::ROLE_DEACTIVATE.
        //     if ($user->getRoles()[0] === User::ROLE_DEACTIVATE) {
        //         // We set the role with the value of User::ROLE_USER.
        //         $user->setRoles(User::ROLE_USER);
        //         // We call the getManager() method.
        //         // We backup the data in the database.
        //         $this->getDoctrine()->getManager()->flush();
        //     }

        //     // We display a flash message for the user.
        //     $this->addFlash('success', 'Bonjour ' . $user->getFirstName() . ', votre compte a bien été réactivé.');

        //     // We redirect the user to the profile page with a array of optional data.
        //     // We specify the related HTTP response status code.
        //     return $this->redirectToRoute('user_profile', ['id' => $user->getId()], 301);
        // }  // Else, somebody try to hack us.
        // else {
        //     // We redirect the user to the page 403.
        //     // We specify the related HTTP response status code.
        //     return new Response('Action interdite', 403);
        // }
        // // TODO END.
        // ! END.
    }

    /**
     * @Route("/{id}/compte-bannis", name="user_banned_account", methods={"GET"})
     *
     * @return Response
     */
    public function bannedAccount(): Response
    {
        // We display the page we want with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->render(
            'user/banned.html.twig',
            [],
            new Response('', 200)
        );
    }
}
