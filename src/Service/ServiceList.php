<?php

namespace App\Service;

use App\Repository\ServiceRepository;

class ServiceList
{

   public $services;

   public function __construct(ServiceRepository $service)
   {
      $this->services = $service;

   }

   /**
    * Method to get all service data and send it to all twig template
    *
    * @return void
    */
   public function shareService ()
   {
      
      $list = $this->services->findAll();
      return $list;
   }
}