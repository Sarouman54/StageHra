<?php

namespace App\Entity;

use App\Repository\DataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $time;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gps;

    /**
     * @ORM\OneToMany(targetEntity=DataType::class, mappedBy="id_data")
     */
    private $data_type;

    public function __construct()
    {
        $this->data_type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getGps(): ?string
    {
        return $this->gps;
    }

    public function setGps(string $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * @return Collection|DataType[]
     */
    public function getDataType(): Collection
    {
        return $this->data_type;
    }

    public function addDataType(DataType $dataType): self
    {
        if (!$this->data_type->contains($dataType)) {
            $this->data_type[] = $dataType;
            $dataType->setIdData($this);
        }

        return $this;
    }

    public function removeDataType(DataType $dataType): self
    {
        if ($this->data_type->removeElement($dataType)) {
            // set the owning side to null (unless already changed)
            if ($dataType->getIdData() === $this) {
                $dataType->setIdData(null);
            }
        }

        return $this;
    }
}
