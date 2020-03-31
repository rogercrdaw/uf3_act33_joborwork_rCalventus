<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 */
class Candidat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cognoms;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $estudis;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuari;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Oferta", mappedBy="candidats")
     */
    private $ofertas;

    public function __construct()
    {
        $this->ofertas = new ArrayCollection();
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

    public function getCognoms(): ?string
    {
        return $this->cognoms;
    }

    public function setCognoms(string $cognoms): self
    {
        $this->cognoms = $cognoms;

        return $this;
    }

    public function getTelefon(): ?int
    {
        return $this->telefon;
    }

    public function setTelefon(int $telefon): self
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function getEstudis(): ?string
    {
        return $this->estudis;
    }

    public function setEstudis(?string $estudis): self
    {
        $this->estudis = $estudis;

        return $this;
    }

    public function getUsuari(): ?User
    {
        return $this->usuari;
    }

    public function setUsuari(User $usuari): self
    {
        $this->usuari = $usuari;

        return $this;
    }

    /**
     * @return Collection|Oferta[]
     */
    public function getOfertas(): Collection
    {
        return $this->ofertas;
    }

    public function addOferta(Oferta $oferta): self
    {
        if (!$this->ofertas->contains($oferta)) {
            $this->ofertas[] = $oferta;
            $oferta->addCandidat($this);
        }

        return $this;
    }

    public function removeOferta(Oferta $oferta): self
    {
        if ($this->ofertas->contains($oferta)) {
            $this->ofertas->removeElement($oferta);
            $oferta->removeCandidat($this);
        }

        return $this;
    }
}
