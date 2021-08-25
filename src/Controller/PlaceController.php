<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /*
    * @Route("/api/place", name="api_place")
    */
 public function index(PlaceRepository $placeRepository): Response
 {
 $places = $placeRepository->findAll();
  $json = json_encode($places);
 $reponse = new Response($json, 200, [
 'content-type' => 'application/json'
 ]);
 return $reponse;
}

        
    
    
}
