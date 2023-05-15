<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $reservation_number = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\ManyToOne(inversedBy: 'Planning')]
    private ?Mairie $mairie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationNumber(): ?int
    {
        return $this->reservation_number;
    }

    public function setReservationNumber(int $reservation_number): self
    {
        $this->reservation_number = $reservation_number;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMairie(): ?Mairie
    {
        return $this->mairie;
    }

    public function setMairie(?Mairie $mairie): self
    {
        $this->mairie = $mairie;

        return $this;
    }
}
