<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\PersonRepository;

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
}
