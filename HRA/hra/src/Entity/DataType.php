<?php

namespace App\Entity;

use App\Repository\DataTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataTypeRepository::class)
 */
class DataType
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
    private $data_type;

    /**
     * @ORM\OneToMany(targetEntity=Data::class, mappedBy="id_type")
     */
    private $data;


    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataType(): ?string
    {
        return $this->data_type;
    }

    public function setDataType(string $data_type): self
    {
        $this->data_type = $data_type;

        return $this;
    }

    /**
     * @return Collection|Data[]
     */
    public function getData(): Collection
    {
        return $this->data;
    }
}
