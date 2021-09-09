<?php

namespace App\Controller\Api;

use App\Entity\Review;
use App\Entity\User;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/review")
 */
class ReviewController extends AbstractController
{
    // Proprietes availables in the object.
    private $entityManager;

    // Proprietes availables in every method of the object.
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/made", name="api_review_made_list", methods={"GET"})
     */
    public function madeList(UserInterface $userInterface): Response
    {
        // We get the current user who is logged in.
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
 
        // We display the page with a array of optional data.
        // We specify the related HTTP response status code.
        return $this->json($madeReviews, 200, [], [
             'groups' => 'reviews'
         ]);

        // TODO START : try with QueryBuilder.
        // We get the current user who is logged in.
        // $loggedInUserId = $userInterface->getId();
        // dd($loggedInUserId);

        // // We call the EnityManager.
        // $entityManager = $this->getDoctrine()->getManager();

        // // We call the QueryBuilder.
        // $queryBuilder = $entityManager->createQueryBuilder('review');
        // // $queryBuilder = $this->createQueryBuilder('review');
        // // We specify that we want the id for avoid SQL injection.
        // $queryBuilder->where('review.id = :id');
        // // We target the id.
        // $queryBuilder->setParameter(':id', $loggedInUserId);
        // // We joint on the review.
        // $queryBuilder->leftJoin('reviews.author', 'authorId');
        // // We create the query.
        // $madeReviews = $queryBuilder->getQuery();
        // // We execute the query.
        // return $madeReviews->getOneOrNullResult();

        // // We display the page with a array of optional data.
        // // We specify the related HTTP response status code.
        // return $this->json($madeReviews, 200, [], [
        //     'groups' => 'reviews'
        // ]);
        // TODO END.
    }
 
    /**
     * @Route("/received", name="api_review_received_list", methods={"GET"})
     */
    public function receivedList(UserRepository $userRepository, UserInterface $userInterface): Response
    {
        // TODO START : not working.
        // // We get the current user who is logged in.
        // $loggedInUserId = $userInterface->getId();
        // // We fetch form the database the data of the logged in user.
        // $loggedInUser = $userRepository->find($loggedInUserId);
        // // We get all the reviews received by the user.
        // $reviews = $loggedInUser->getReviews();
        // // We set a empty array to get the first name of each review's author.
        // $authorNames[] = null;

        // foreach ($reviews as $currentReview) {
        //     // We get the author's id of the current review.
        //     $authorId = $currentReview->getAuthorId();
        //     // W get the name of the current author's id.
        //     $authorName = $userRepository->find($authorId)->getFirstName();
        //     // We fill in the array with all the authors of the reviews.
        //     $authorsNamesList[] = $authorName;
        // }

        // // We display the page with a array of optional data.
        // // We specify the related HTTP response status code.
        // return $this->json($reviews, 200, [
        //     'groups' => 'reviews'
        // ]);
        // TODO END.
    }

    /**
     * @Route("", name="api_review_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validatorInterface): Response
    {
        // TODO START : not working.
        // // We get the data in JSON.
        // $jsonData = $request->getContent();

        // // We use the deserialize() method to convert the JSON in objet.
        // $review = $serializerInterface->deserialize($jsonData, Review::class, 'json');

        // // We check if the Asserts of the Review Entity are respected.
        // $errors = $validatorInterface->validate($review);

        // // If the number of error is uppder than 0.
        // if (count($errors) > 0) {
        //     // We have at least one error.
        //     // We display the eventual errors for the user.
        //     // We specify the related HTTP response status code.
        //     return $this->json([
        //         'errors' => (string) $errors
        //     ], 500);
        // } // Else we don't count any error.
        // else {
        //     // We call the getManager() method.
        //     $entityManager = $this->getDoctrine()->getManager();
        //     // We persist the data.
        //     $entityManager->persist($review);
        //     // We backup the data in the database.
        //     $entityManager->flush();

        //     // We display a flash message for the user.
        //     // We specify the related HTTP response status code.
        //     return $this->json([
        //         'message' => 'La review a bien été créee.'
        //     ], 201);
        // }
        // TODO END.
    }

    /**
     * @Route("/{id}", name="api_review_delete", methods={"DELETE"})
     */
    public function delete(Review $review): Response
    {
        // We delete the review.
        $this->entityManager->remove($review);
        // We backup in database the information specifying that it be deleted.
        $this->entityManager->flush();

        // We display a flash message for the user.
        // We specify the related HTTP response status code.
        return $this->json([
            'message' => 'La review que vous avez adressée à ' .$review->getAuthorId(). ' a bien été supprimé.'
        ], 200);
    }
}
