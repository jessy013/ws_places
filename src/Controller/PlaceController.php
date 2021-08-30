<?php

namespace App\Controller;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

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
    * @Route("/api/place", name="api_place_add" , methods="POST")
    */
    public function index2(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
 $contenu = $request->getContent();
        try
    {
        $place = $serializer->deserialize($contenu, Place::class, 'json');
        $errors = $validator->validate($place);
        if (count($errors) > 0)
    {
        return $this->json($errors, 400);
    }
        $entityManager->persist($place);
        $entityManager->flush();
        return $this->json($place, 201, [],
        ['groups' => 'place:read']);
    }
        catch (NotEncodableValueException $e)
    {
        return $this->json(['status' => 400,'message' => $e->getMessage()]);
    }
}  
  
}
