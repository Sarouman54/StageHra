<?php

namespace App\Entity;

use App\Repository\DataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataRepository::class)
 */
class Data
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
    private $nmea;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=Truck::class, inversedBy="id_data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_truck;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNmea(): ?string
    {
        return $this->nmea;
    }

    public function setNmea(string $nmea): self
    {
        $this->nmea = $nmea;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdTruck(): ?Truck
    {
        return $this->id_truck;
    }

    public function setIdTruck(?Truck $id_truck): self
    {
        $this->id_truck = $id_truck;

        return $this;
    }

}
