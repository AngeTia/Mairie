<?php

namespace App\Controller;

use App\Entity\Mairie;
use App\Repository\MairieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MairieController extends AbstractController
{
    // Route pour récupérer toutes les mairies
    #[Route('/api/mairies', name: 'all_mairie', methods: ['GET'])]
    public function getAllMairies(MairieRepository $mairieRepository, SerializerInterface $serializer): JsonResponse
    {
        $mairies = $mairieRepository->findAll();
        
        $mairiesJson = $serializer->serialize($mairies, 'json');
        return new JsonResponse($mairiesJson, Response::HTTP_OK, [], true);
    }

    // Route pour récupérer une mairie par son id
    #[Route('/api/mairies/{id}', name: 'mairie', methods: ['GET'])]
    public function getDetailMairie(Mairie $mairie, MairieRepository $mairieRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
        $mairieJson = $serializer->serialize($mairie, 'json');
        return new JsonResponse($mairieJson, Response::HTTP_OK, [], true);
        
    }

    // Route pour supprimer une mairie par son id
    #[Route('/api/mairies/delete/{id}', name: 'deleteMairie', methods: ['DELETE'])]
    public function deleteMairie(Mairie $mairie, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($mairie);
        $delete->flush();
        return new JsonResponse('Mairie supprimé avec succès', Response::HTTP_OK);
    }

    // Route pour ajouter une mairie
    #[Route('/api/mairies/create', name: 'addMairie', methods: ['POST'])]
    public function addMairie(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $mairie = $serializer->deserialize($request->getContent(), Mairie::class, 'json');
        $add->persist($mairie);
        $add->flush();

        $jsonMairie = $serializer->serialize($mairie, 'json');
        return new JsonResponse($jsonMairie, Response::HTTP_CREATED, [], true);
    }

    // Route pour modifier une mairie par son id
    #[Route('/api/mairies/update/{id}', name: 'updateMairie', methods: ['PUT'])]
    public function updateMairie(Mairie $mairie, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $mairie = $serializer->deserialize($request->getContent(), Mairie::class, 'json', ['object_to_populate' => $mairie]);
        $update->persist($mairie);
        $update->flush();

        $jsonMairie = $serializer->serialize($mairie, 'json');
        return new JsonResponse($jsonMairie, Response::HTTP_OK, [], true);
    }
    
}
