<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
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
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $RecrutedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Services", inversedBy="IdService")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ServiceId;

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

    public function getRecrutedAt(): ?\DateTimeInterface
    {
        return $this->RecrutedAt;
    }

    public function setRecrutedAt(\DateTimeInterface $RecrutedAt): self
    {
        $this->RecrutedAt = $RecrutedAt;

        return $this;
    }

    public function getServiceId(): ?Services
    {
        return $this->ServiceId;
    }

    public function setServiceId(?Services $ServiceId): self
    {
        $this->ServiceId = $ServiceId;

        return $this;
    }
}
