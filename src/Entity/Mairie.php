<?php

namespace App\Entity;

use App\Repository\MairieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MairieRepository::class)]
class Mairie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $addresse = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'mairie', targetEntity: Planning::class)]
    private Collection $Planning;

    #[ORM\OneToMany(mappedBy: 'mairie', targetEntity: Reservation::class)]
    private Collection $Reservation;

    #[ORM\OneToMany(mappedBy: 'mairie', targetEntity: Users::class)]
    private Collection $Users;

    public function __construct()
    {
        $this->Planning = new ArrayCollection();
        $this->Reservation = new ArrayCollection();
        $this->Users = new ArrayCollection();
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

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlanning(): Collection
    {
        return $this->Planning;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->Planning->contains($planning)) {
            $this->Planning->add($planning);
            $planning->setMairie($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->Planning->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getMairie() === $this) {
                $planning->setMairie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->Reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->Reservation->contains($reservation)) {
            $this->Reservation->add($reservation);
            $reservation->setMairie($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->Reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMairie() === $this) {
                $reservation->setMairie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users->add($user);
            $user->setMairie($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->Users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMairie() === $this) {
                $user->setMairie(null);
            }
        }

        return $this;
    }

}
