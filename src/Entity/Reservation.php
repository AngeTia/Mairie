<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\Column(length: 255)]
    private ?string $date = null;

    #[ORM\Column(length: 255)]
    private ?string $time = null;

    #[ORM\Column]
    private ?bool $payement_status = null;

    #[ORM\Column(length: 255)]
    private ?string $payement_date = null;

    #[ORM\ManyToOne(inversedBy: 'Reservation')]
    private ?Mairie $mairie = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: CheckFolder::class)]
    private Collection $CheckFolder;

    public function __construct()
    {
        $this->CheckFolder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function isPayementStatus(): ?bool
    {
        return $this->payement_status;
    }

    public function setPayementStatus(bool $payement_status): self
    {
        $this->payement_status = $payement_status;

        return $this;
    }

    public function getPayementDate(): ?string
    {
        return $this->payement_date;
    }

    public function setPayementDate(string $payement_date): self
    {
        $this->payement_date = $payement_date;

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

    /**
     * @return Collection<int, CheckFolder>
     */
    public function getCheckFolder(): Collection
    {
        return $this->CheckFolder;
    }

    public function addCheckFolder(CheckFolder $checkFolder): self
    {
        if (!$this->CheckFolder->contains($checkFolder)) {
            $this->CheckFolder->add($checkFolder);
            $checkFolder->setReservation($this);
        }

        return $this;
    }

    public function removeCheckFolder(CheckFolder $checkFolder): self
    {
        if ($this->CheckFolder->removeElement($checkFolder)) {
            // set the owning side to null (unless already changed)
            if ($checkFolder->getReservation() === $this) {
                $checkFolder->setReservation(null);
            }
        }

        return $this;
    }

    
}