<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PlanningController extends AbstractController
{
    // Route pour récupérer toutes les plannings
    #[Route('/api/planning', name: 'all_planning', methods: ['GET'])]
    public function getAllMairies(PlanningRepository $planningRepository, SerializerInterface $serializer): JsonResponse
        {
            $planning = $planningRepository->findAll();
            
            $planningJson = $serializer->serialize($planning, 'json');
            return new JsonResponse($planningJson, Response::HTTP_OK, [], true);
        }

    // Route pour récupérer un planning par son id
    #[Route('/api/planning/{id}', name: 'planning', methods: ['GET'])]
    public function getDetailPlanning(Planning $planning, PlanningRepository $planningRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
        $planningJson = $serializer->serialize($planning, 'json');
        return new JsonResponse($planningJson, Response::HTTP_OK, [], true);
        
    }

    // Route pour supprimer un planning par son id
    #[Route('/api/planning/delete/{id}', name: 'deleteMairie', methods: ['DELETE'])]
    public function deleteMairie(Planning $planning, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($planning);
        $delete->flush();
        return new JsonResponse('Planning supprimé avec succès', Response::HTTP_OK);
    }

    // Route pour ajouter un planning supplementaire
    #[Route('/api/planning/create', name: 'addPlanning', methods: ['POST'])]
    public function addPlanning(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $planning = $serializer->deserialize($request->getContent(), Planning::class, 'json');
        $add->persist($planning);
        $add->flush();

        $jsonPlanning = $serializer->serialize($planning, 'json');
        return new JsonResponse($jsonPlanning, Response::HTTP_CREATED, [], true);
    }

    // Route pour modifier un planning par son id
    #[Route('/api/planning/update/{id}', name: 'updatePlanning', methods: ['PUT'])]
    public function updateMairie(Planning $planning, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $planning = $serializer->deserialize($request->getContent(), Planning::class, 'json', ['object_to_populate' => $planning]);
        $update->persist($planning);
        $update->flush();

        $jsonMairie = $serializer->serialize($planning, 'json');
        return new JsonResponse($jsonMairie, Response::HTTP_OK, [], true);
    }
    
}
