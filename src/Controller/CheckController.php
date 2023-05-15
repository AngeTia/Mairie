<?php

namespace App\Controller;

use App\Entity\CheckFolder;
use App\Repository\CheckFolderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CheckController extends AbstractController
{
    // Route pour récupérer tout
    #[Route('/api/check', name: 'app_check', methods: ['GET'])]
    public function getAllCheck(CheckFolderRepository $checkFolderRepository, SerializerInterface $serializer): JsonResponse
    {
        $check = $checkFolderRepository->findAll();
        
        $checkJson = $serializer->serialize($check, 'json');
        return new JsonResponse($checkJson, Response::HTTP_OK, [], true);
    }

    // Route pour récupérer un check
    #[Route('/api/check/{id}', name: 'ckeck', methods: ['GET'])]
    public function getDetailCheck(CheckFolder $checkFolder, CheckFolderRepository $checkFolderRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
        $checkJson = $serializer->serialize($checkFolder, 'json');
        return new JsonResponse($checkJson, Response::HTTP_OK, [], true);
        
    }

    // Route pour supprimer un check par son id
    #[Route('/api/check/delete/{id}', name: 'deleteCheck', methods: ['DELETE'])]
    public function deleteCheck(CheckFolder $checkFolder, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($checkFolder);
        $delete->flush();
        return new JsonResponse('Mairie supprimé avec succès', Response::HTTP_OK);
    }

    // Route pour ajouter un check
    #[Route('/api/check/create', name: 'addCheck', methods: ['POST'])]
    public function addCheck(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $check = $serializer->deserialize($request->getContent(), CheckFolder::class, 'json');
        $add->persist($check);
        $add->flush();

        $jsonCheck = $serializer->serialize($check, 'json');
        return new JsonResponse($jsonCheck, Response::HTTP_CREATED, [], true);
    }

    // Route pour modifier un check par son id
    #[Route('/api/check/update/{id}', name: 'updateCheck', methods: ['PUT'])]
    public function updateCheck(CheckFolder $checkFolder, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $check = $serializer->deserialize($request->getContent(), CheckFolder::class, 'json', ['object_to_populate' => $checkFolder]);
        $update->persist($check);
        $update->flush();

        $jsonCheck = $serializer->serialize($check, 'json');
        return new JsonResponse($jsonCheck, Response::HTTP_OK, [], true);
    }
}
