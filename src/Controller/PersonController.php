<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Person;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     */
    public function index1(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
    /**
    * @Route("/api/person", name="api_person", methods="GET")
    */
    public function index2(PersonRepository $personRepository,NormalizerInterface $normalizer): Response
    {
    $personnes = $personRepository->findAll();
    $normalized = $normalizer->normalize($personnes, null,
     ['groups' => 'person:read']
);
     $json = json_encode($normalized);
    $reponse = new Response($json, 200, [
    'content-type' => 'application/json'
    ]);
    return $reponse;
    }
    /**
    * @Route("/api/person/", name="api_person_add",methods="POST")
    */
  public function add1(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator) {
      
    {
        $contenu = $request->getContent();
        try
    {
        $personne = $serializer->deserialize($contenu, Person::class, 'json');
        $errors = $validator->validate($personne);
        if (count($errors) > 0)
    {
        return $this->json($errors, 400);
    }
        $entityManager->persist($personne);
        $entityManager->flush();
        return $this->json($personne, 201, [],
        ['groups' => 'person:read']);
    }
        catch (NotEncodableValueException $e)
    {
        return $this->json(['status' => 400,'message' => $e->getMessage()]);
    }
}
}
}
