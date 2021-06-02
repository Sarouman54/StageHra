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
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=Truck::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_truck;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nmea;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdTruck(): ?truck
    {
        return $this->id_truck;
    }

    public function setIdTruck(?truck $id_truck): self
    {
        $this->id_truck = $id_truck;

        return $this;
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
}
