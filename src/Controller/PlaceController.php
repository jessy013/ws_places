<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PlaceController extends AbstractController
{
    /*
    * @Route("/api/place", name="api_place")
    */
 public function index1(PlaceRepository $placeRepository): Response
 {
 $places = $placeRepository->findAll();
  $json = json_encode($places);
 $reponse = new Response($json, 200, [
 'content-type' => 'application/json'
 ]);
 return $reponse;
}
 /**
 * @Route("/api/place/{id}", name="api_place_avec_id")
 */
 public function findById(PlaceRepository $placeRepository,$id): Response
 {
    $place = $placeRepository->find($id);
    $json = json_encode($place);
    $reponse = new Response($json, 200, [
    'content-type' => 'application/json'
    ]);
    return $reponse;
}
        /**
    * @Route("/api/place", name="api_place" , methods="GET")
    */
    public function index2(PlaceRepository $placeRepository
    ,NormalizerInterface $normalizer): Response
    {
    $places = $placeRepository->findAll();
    $normalized = $normalizer->normalize($places);
    $json = json_encode($normalized);
    $reponse = new Response($json, 200, [
    'content-type' => 'application/json'
    ]);
    return $reponse;
}  
  
}
