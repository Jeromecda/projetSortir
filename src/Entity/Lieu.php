<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LieuRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("api")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups("api")
     */
    private $rue;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("api")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("api")
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="lieus")
     * @Groups("api")
     * @ORM\JoinColumn(nullable=false)
     */
    private $villeNoVille;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="lieuNolieu", orphanRemoval=true)
     */
    private $sorties;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVilleNoVille(): ?Ville
    {
        return $this->villeNoVille;
    }

    public function setVilleNoVille(?Ville $villeNoVille): self
    {
        $this->villeNoVille = $villeNoVille;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setLieuNolieu($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getLieuNolieu() === $this) {
                $sorty->setLieuNolieu(null);
            }
        }

        return $this;
    }
}
