<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Repository\FolderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FolderController extends AbstractController
{
   // Route pour récupérer toutes les dossiers
    #[Route('/api/folder', name: 'all_folder', methods: ['GET'])]
    public function getAllFolder(FolderRepository $folderRepository, SerializerInterface $serializer): JsonResponse
    {
        $folder = $folderRepository->findAll();

        $folderJson = $serializer->serialize($folder, 'json');
        return new JsonResponse($folderJson, Response::HTTP_OK, [], true);
    }

    // Route pour récupérer un dossier par son id
    #[Route('/api/folder/{id}', name: 'folder', methods: ['GET'])]
    public function getDetailMairie(Folder $folder, FolderRepository $folderRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
            $folderJson = $serializer->serialize($folder, 'json');
            return new JsonResponse($folderJson, Response::HTTP_OK, [], true);
        
    }

   // Route pour supprimer un dossier par son id
    #[Route('/api/folder/delete/{id}', name: 'deleteFolder', methods: ['DELETE'])]
    public function deleteFolder(Folder $folder, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($folder);
        $delete->flush();
        return new JsonResponse('Mairie supprimé avec succès', Response::HTTP_OK);
    }

   // Route pour ajouter un dossier
    #[Route('/api/folder/create', name: 'addFolder', methods: ['POST'])]
    public function addFolder(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $folder = $serializer->deserialize($request->getContent(), Folder::class, 'json');
        $add->persist($folder);
        $add->flush();

        $jsonReservation = $serializer->serialize($folder, 'json');
        return new JsonResponse($jsonReservation, Response::HTTP_CREATED, [], true);
    }

   // Route pour modifier un dossier par son id
    #[Route('/api/folder/update/{id}', name: 'updateFolder', methods: ['PUT'])]
    public function updateMairie(Folder $folder, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $folder = $serializer->deserialize($request->getContent(), Folder::class, 'json', ['object_to_populate' => $folder]);
        $update->persist($folder);
        $update->flush();

        $jsonFolder = $serializer->serialize($folder, 'json');
        return new JsonResponse($jsonFolder, Response::HTTP_OK, [], true);
    }
}
