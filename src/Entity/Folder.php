<?php

namespace App\Entity;

use App\Repository\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: CheckFolder::class)]
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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
            $checkFolder->setFolder($this);
        }

        return $this;
    }

    public function removeCheckFolder(CheckFolder $checkFolder): self
    {
        if ($this->CheckFolder->removeElement($checkFolder)) {
            // set the owning side to null (unless already changed)
            if ($checkFolder->getFolder() === $this) {
                $checkFolder->setFolder(null);
            }
        }

        return $this;
    }
}
