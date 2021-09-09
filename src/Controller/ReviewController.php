<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/evaluation", name="review_")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("/{id}/ajouter", name="add", methods={"GET","POST"}, requirements={"id" = "\d+"})
     */
    public function add(int $id, Request $request, UserInterface $userInterface, UserRepository $userRepository): Response
    {
        // Get the user info to be reviewed
        $reviewedUser = $userRepository->find($id);

        // Get the author id
        $authorId = $userInterface->getId();

        // Review instance
        $review = new Review();

        // Set the user to be the current user to be review
        $review->setUser($reviewedUser);

        // Create a form to add a review
        $reviewForm = $this->createForm(ReviewType::class, $review);

        // Process the form on submit
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            // Fill the Review object with the values of the form
            $review = $reviewForm->getData();

            // Change the Review object 'author' property
            $review->setAuthorId($authorId);

            // Add the review to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            // Redirect the reviewed user's profile
            return $this->redirectToRoute('show_angel', ['id' => $id]);
        }

        return $this->render('review/add.html.twig', [
            'reviewForm' => $reviewForm->createView(),
            'authorId' => $authorId,
            'reviewedUser' => $reviewedUser
        ]);
    }

    /**
     * @Route("/emis", name="made-list", methods="GET")
     */
    public function madeList(UserInterface $userInterface) : Response
    {
        // Get logged-in user'id
        $loggedInUserId = $userInterface->getId();
        // Entity Manager
        $em = $this->getDoctrine()->getManager();
        // Create the DQL query : SELECT * FROM `review` WHERE author_id = $loggedInUserId
        $query = $em->createQuery(
            'SELECT review 
            FROM App\Entity\Review review 
            WHERE review.authorId = ' . $loggedInUserId
        );

        // Fetch the reviews written by the logged-in user
        $madeReviews = $query->getResult();

        return $this->render('review/made-list.html.twig', [
            'madeReviews' => $madeReviews
        ]);
    }

    /**
     * @Route("/recu", name="received-list", methods="GET")
     */
    public function receivedList(UserRepository $userRepository, UserInterface $userInterface) : Response
    {
        // Get logged-in user'id
        $loggedInUserId = $userInterface->getId();
        // Fetch from DB logged-in user data
        $currentUser = $userRepository->find($loggedInUserId);
        // Get all received reviews from the logged-in user
        $reviews = $currentUser->getReviews();

        // Get the firstName of each review's author
        $authorNameArray[] = '';

        foreach ($reviews as $currentReview) {
            // Get the author's id of the current review
            $currentAuthorId = $currentReview->getAuthorId();
            // Get the name of the current author's id
            $currentAuthorName = $userRepository->find($currentAuthorId)->getFirstName();
            // Fill an array with all the authors of the reviews
            $authorNameArray[] = $currentAuthorName;
        }

        return $this->render('review/received-list.html.twig', [
            'reviews' => $reviews,
            'authorNameArray' => $authorNameArray,
        ]);
    }
}
