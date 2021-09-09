<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/admin/review")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("", name="admin_review_index", methods={"GET"})
     */
    public function index(ReviewRepository $reviewRepository, UserRepository $userRepository): Response
    {
         // Get the firstName of each review's author
            $authorNameArray[] = '';
            $reviews = $reviewRepository->findAll();
         
        foreach ($reviews as $review) {
            // Get the author's id of the current review
            $authorId[] = $review->getAuthorId();
        }
        foreach($authorId as $id){
            $users[] = $userRepository->find($id);}
            // Get the name of the current author's id
            foreach($users as $user){
            if ($user ==  null){
                $authorFirstName = "auteur supprimé";
                
            }else{
                $authorFirstName = $user->getFirstName();
                
            }
            $authorList[]=$authorFirstName;}
        
        
            // if ($currentAuthorId !== 0) {
            //     // Get the Author's object of a review
            //     $currentAuthor = $userRepository->find($currentAuthorId);
            //     if ($currentAuthor !== null ) {
            //         $currentAuthorFirstName = $currentAuthor->getFirstName();
            //         $currentAuthorLastName = $currentAuthor->getLastName();
            //         // Fill an array with all the authors of the reviews
            //         $currentAuthorName = $currentAuthorFirstName . ' ' . $currentAuthorLastName;
            //         $authorNameArray[] = $currentAuthorName;
            //     }
            // }
            
        

        
        return $this->render('admin/review/index.html.twig', [
         'reviews' => $reviews,
         'authorList' => $authorList,
            
        ]);
    }

    /**
     * @Route("/{id}", name="admin_review_approved", methods={"GET"})
     */
    public function approved(Review $review): Response
    {

         $newStatus = '1';
         $review->setStatus($newStatus);
         $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();
            $this->addFlash('success', 'Ce commentaire vient d\'être approuvé');
            return $this->redirectToRoute('admin_review_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="admin_review_delete", methods={"POST"})
     */
    public function delete(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_review_index', [], Response::HTTP_SEE_OTHER);
    }
}