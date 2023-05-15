<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ReservationController extends AbstractController
{
    // Route pour récupérer toutes les réservations
    #[Route('/api/reservation', name: 'app_reservation', methods: ['GET'])]
    public function getAllReservation(ReservationRepository $reservationRepository, SerializerInterface $serializer): JsonResponse
    {
        $reservation = $reservationRepository->findAll();
        $reservationJson = $serializer->serialize($reservation, 'json');
        return new JsonResponse($reservationJson, Response::HTTP_OK, [], true);
    }

    // Route pour récupérer une réservation par son id
    #[Route('/api/reservation/{id}', name: 'reservation', methods: ['GET'])]
    public function getDetailMairie(Reservation $reservation, ReservationRepository $reservationRepository, SerializerInterface $serializer): JsonResponse
    {   
        // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne la mairie
        $ReservationJson = $serializer->serialize($reservation, 'json');
        return new JsonResponse($ReservationJson, Response::HTTP_OK, [], true);
        
    }

    // Route pour modifier une mairie par son id
    #[Route('/api/reservation/update/{id}', name: 'updateReservation', methods: ['PUT'])]
    public function updateMairie(Reservation $reservation, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    {
        $reservation = $serializer->deserialize($request->getContent(), Reservation::class, 'json', ['object_to_populate' => $reservation]);
        $update->persist($reservation);
        $update->flush();

        $jsonMairie = $serializer->serialize($reservation, 'json');
        return new JsonResponse($jsonMairie, Response::HTTP_OK, [], true);
    }

    // Route pour supprimer une mairie par son id
    #[Route('/api/reservation/delete/{id}', name: 'deleteReservation', methods: ['DELETE'])]
    public function deleteReservation(Reservation $reservation, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($reservation);
        $delete->flush();
        return new JsonResponse('Reservation supprimé avec succès', Response::HTTP_OK);
    }

    // Route pour ajouter une reservation
    #[Route('/api/reservation/create', name: 'addReservation', methods: ['POST'])]
    public function addReservation(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
    {
        $reservation = $serializer->deserialize($request->getContent(), Reservation::class, 'json');
        $add->persist($reservation);
        $add->flush();

        $jsonReservation = $serializer->serialize($reservation, 'json');
        return new JsonResponse($jsonReservation, Response::HTTP_CREATED, [], true);
    }
}
