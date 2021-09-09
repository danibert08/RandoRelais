<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddressApi 
{
   private $client;
   private $slugger;
   private $ApiUrl = 'https://api-adresse.data.gouv.fr/search/?q=';

   public function __construct(HttpClientInterface $client, SluggerInterface $slugger)
   {
      $this->client = $client;
      $this->slugger = $slugger;
   }

   /**
    * Method to get the gps coordinates of an angel
    *
    * @param [type] $city
    * @param [type] $zipCode
    * @return void
    */
   public function getCoordinatesWithAddress ($user)
   {

      // if a someone create an angel account we use addressApi service to get the gps coordinates of his city
      if ($user->getStatus() === 2) {
         // Get city and zipCode of the new subscriber to use addressApi service
         $city = $user->getCity();
         $zipCode = $user->getZipCode();
      
         // We slug the city name
         $citySlug = $this->slugger->slug($city);
         // client do the request
         $response = $this->client->request('GET', $this->ApiUrl.$citySlug.'&postcode='.$zipCode);
         $arrayResponse = $response->toArray();
        
         // Recover the latitude and longitude of the city
         $lat = $arrayResponse["features"][0]["geometry"]["coordinates"][1];
         $lon = $arrayResponse["features"][0]["geometry"]["coordinates"][0];
         // Set the latitude and longitude of the subscriber before flush in database
         $user->setLatitude($lat);
         $user->setLongitude($lon);

         return $user;

     } else {
        
        return $user;
     }
   }
}