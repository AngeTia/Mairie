<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends AbstractController
{
    // Route pour récupérer tous les Users
    #[Route('/api/users', name: 'app_users', methods: ['GET'])]
    public function getAllMairies(UsersRepository $usersRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $usersRepository->findAll();
        
        $usersJson = $serializer->serialize($users, 'json');
        return new JsonResponse($usersJson, Response::HTTP_OK, [], true);
    }

    // Route pour récupérer un user par son id
    #[Route('/api/users/{id}', name: 'user', methods: ['GET'])]
    public function getDetailUser(Users $users, UsersRepository $usersRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
        $userJson = $serializer->serialize($users, 'json');
        return new JsonResponse($userJson, Response::HTTP_OK, [], true);
        
    }

    // Route pour supprimer un user par son id
    #[Route('/api/users/delete/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(Users $users, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($users);
        $delete->flush();
        return new JsonResponse('User supprimé avec succès', Response::HTTP_OK);
    }

    // Route pour ajouter un user
    #[Route('/api/users/create', name: 'addUsers', methods: ['POST'])]
    public function addMairie(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $users = $serializer->deserialize($request->getContent(), Users::class, 'json');
        $add->persist($users);
        $add->flush();

        $jsonMairie = $serializer->serialize($users, 'json');
        return new JsonResponse($jsonMairie, Response::HTTP_CREATED, [], true);
    }

    // Route pour modifier un user par son id
    #[Route('/api/users/update/{id}', name: 'updateUsers', methods: ['PUT'])]
    public function updateMairie(Users $users, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $users = $serializer->deserialize($request->getContent(), Users::class, 'json', ['object_to_populate' => $users]);
        $update->persist($users);
        $update->flush();

        $jsonUsers = $serializer->serialize($users, 'json');
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }
}
