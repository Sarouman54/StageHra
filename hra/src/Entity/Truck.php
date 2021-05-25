<?php

namespace App\Entity;

use App\Repository\TruckRepository;
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
}
