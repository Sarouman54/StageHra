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
     * @ORM\Column(type="string", length=255)
     */
    private $nmea;

    /**
     * @ORM\ManyToOne(targetEntity=Truck::class, inversedBy="id_data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_truck;

    /**
     * @ORM\ManyToOne(targetEntity=DataType::class, inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type;

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

    public function getNmea(): ?string
    {
        return $this->nmea;
    }

    public function setNmea(string $nmea): self
    {
        $this->nmea = $nmea;

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

    public function getIdType(): ?DataType
    {
        return $this->id_type;
    }

    public function setIdType(?DataType $id_type): self
    {
        $this->id_type = $id_type;

        return $this;
    }
}
