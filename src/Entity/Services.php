<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Services;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServicesRepository")
 */
class Services
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="ServiceId", orphanRemoval=true)
     */
    private $IdService;

    public function __construct()
    {
        $this->IdService = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getIdService(): Collection
    {
        return $this->IdService;
    }

    public function addIdService(Employee $idService): self
    {
        if (!$this->IdService->contains($idService)) {
            $this->IdService[] = $idService;
            $idService->setServiceId($this);
        }

        return $this;
    }

    public function removeIdService(Employee $idService): self
    {
        if ($this->IdService->contains($idService)) {
            $this->IdService->removeElement($idService);
            // set the owning side to null (unless already changed)
            if ($idService->getServiceId() === $this) {
                $idService->setServiceId(null);
            }
        }

        return $this;
    }
}
