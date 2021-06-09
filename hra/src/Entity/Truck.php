<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $registration;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $id_driver;

    /**
     * @ORM\OneToOne(targetEntity=ElectronicCard::class, cascade={"persist", "remove"})
     */
    private $id_card;

    /**
     * @ORM\OneToMany(targetEntity=Data::class, mappedBy="id_truck")
     */
    private $id_data;

    public function __construct()
    {
        $this->id_data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getIdDriver(): ?user
    {
        return $this->id_driver;
    }

    public function setIdDriver(?user $id_driver): self
    {
        $this->id_driver = $id_driver;

        return $this;
    }

    public function getIdCard(): ?electronicCard
    {
        return $this->id_card;
    }

    public function setIdCard(?electronicCard $id_card): self
    {
        $this->id_card = $id_card;

        return $this;
    }

    /**
     * @return Collection|Data[]
     */
    public function getIdData(): Collection
    {
        return $this->id_data;
    }
}
