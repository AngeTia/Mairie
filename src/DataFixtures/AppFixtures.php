<?php

namespace App\DataFixtures;

use App\Entity\CheckFolder;
use App\Entity\Folder;
use App\Entity\Mairie;
use App\Entity\Planning;
use App\Entity\Reservation;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        // Création d'une vingtaine de réservation
        for ($i = 0; $i < 20; $i++) {
            $reservation = new Reservation;
            $reservation->setNom('Nom de ' . $i);
            $reservation->setPrenom('Prenom de ' . $i);
            $reservation->setContact('Contact de ' . $i);
            $reservation->setDate("2021-01-01");
            $reservation->setTime("12:00:00");
            $reservation->setPayementStatus(true);
            $reservation->setPayementDate("2021-01-01");
            $manager->persist($reservation);
        }
        
        // Création d'une vingtaine de mairie
        for ($i = 0; $i < 20; $i++) {
             // A se niveau, on peut utiliser les setters pour pourvoir leur donner des données aléatoires
            $mairie = new Mairie;
            $mairie->setNom('Mairie de ' . $i);
            $mairie->setAddresse('Addresse de ' . $i);
            $mairie->setPhone('Phone de ' . $i);
            $mairie->setEmail('Email de ' . $i);
            $manager->persist($mairie);

        }

        // On enregistre les données en base de données pour la table folder
        for ($i = 0; $i < 20; $i++) {
            $folder = new Folder;
            $folder->setNom('Nom de ' . $i);
            $folder->setPath('Prenom de ' . $i);
            $manager->persist($folder);
        }

        // On enregistre les données en base de données pour le planning
        for ($i = 0; $i < 20; $i++) {
            $planning = new Planning;
            $planning->setReservationNumber(1 . $i);
            $planning->setDay('Prenom de ' . $i);
            $manager->persist($planning);
        }

        // On enregistre les données en base de données pour la table users
        for ($i = 0; $i < 20; $i++) {
            $user = new Users;
            $user->setFirstname('Nom de ' . $i);
            $user->setLastname('Prenom de ' . $i);
            $user->setEmail('Email de ' . $i);
            $user->setPassword('Password de ' . $i);
            $user->setRole(0 . $i);
            $manager->persist($user);
        }

        // On enregistre les données en base de données pour la table checkfolder
        for ($i = 0; $i < 20; $i++) {
            $user = new CheckFolder;
            $user->setFile('Nom de ' . $i);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
