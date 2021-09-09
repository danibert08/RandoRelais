<?php
namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class ImageUploader{

  protected $slugger;

  public function __construct(SluggerInterface $slugger)
  {
    $this->slugger = $slugger;

  }

  /**
     * Methode permettant de déplacer une image issue d'un formulaire
     * vers un dossier uploads
     *
     * @param Form $form
     * @param string $fieldName
     * @return string|null
     */
  public function imageUpload(Form $formName, string $pictureFieldName, $uploadFolder = null)
  {
   
     $uploadFolder = $uploadFolder ?? $_ENV['UPLOAD_FOLDER'];

      /** @var UploadedFile $imageFile */
      // On récupère le fichier "physique"
      $imageFile = $formName->get($pictureFieldName)->getData();
            // Si on a bien une image à uploader, on va pouvoir
            // la déplacer dans le dossier uploads
      if ($imageFile) {
          $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
          // this is needed to safely include the file name as part of the URL
          /** @var $slugger */
         
          $safeFilename = $this->slugger->slug($originalFilename);
          
          // Image-Social-15424.jpg
          $newFilename = $safeFilename .  '.' . $imageFile->guessExtension();
          
          // On déplace le fichier du dossier temporaire (/tmp/)
                // vers le dossier uploads
          try {
             // Si le déplacement s'est bien passé, on va pouvoir
                    // passer à la mise à jour de l'entité
              $imageFile->move(
                 // $this->getParameter('brochures_directory'),
                 $uploadFolder, //Destination
                 $newFilename // Nom de l'image de destination
              );
              return $newFilename;
          } catch (FileException $e) {
             // Sinon, on affiche une erreur
                    // Envoyer un Email à l'adminstrateur
                    // Envoyer un message au client
          }
          
      }
      // Aucune image à uploader...on retourne null
      return null;
  }
}