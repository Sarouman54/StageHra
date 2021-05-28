<?php

namespace App\Entity;

use App\Repository\DataTypeRepository;
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
     * @ORM\ManyToOne(targetEntity=Data::class, inversedBy="data_type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_data;

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

//     public function getIdData(): ?Data
//     {
//         return $this->id_data;
//     }

//     public function setIdData(?Data $id_data): self
//     {
//         $this->id_data = $id_data;

//         return $this;
//     }
}
