<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfertaRepository")
 */
class Oferta
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
    private $titol;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcio;

    /**
     * @ORM\Column(type="text")
     */
    private $resum;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataPublicacio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $requisits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empresa", inversedBy="ofertas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $empresa;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Candidat", inversedBy="ofertas")
     */
    private $candidats;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitol(): ?string
    {
        return $this->titol;
    }

    public function setTitol(string $titol): self
    {
        $this->titol = $titol;

        return $this;
    }

    public function getDescripcio(): ?string
    {
        return $this->descripcio;
    }

    public function setDescripcio(?string $descripcio): self
    {
        $this->descripcio = $descripcio;

        return $this;
    }

    public function getResum(): ?string
    {
        return $this->resum;
    }

    public function setResum(string $resum): self
    {
        $this->resum = $resum;

        return $this;
    }

    public function getDataPublicacio(): ?\DateTimeInterface
    {
        return $this->dataPublicacio;
    }

    public function setDataPublicacio(\DateTimeInterface $dataPublicacio): self
    {
        $this->dataPublicacio = $dataPublicacio;

        return $this;
    }

    public function getRequisits(): ?string
    {
        return $this->requisits;
    }

    public function setRequisits(?string $requisits): self
    {
        $this->requisits = $requisits;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->contains($candidat)) {
            $this->candidats->removeElement($candidat);
        }

        return $this;
    }
}
