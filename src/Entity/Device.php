<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(length: 20)]
    private ?string $os = null;

    #[ORM\Column(length: 30)]
    private ?string $os_type = null;

    #[ORM\Column(length: 80)]
    private ?string $model = null;

    #[ORM\Column(length: 100)]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 15)]
    private ?string $ip_address = null;

    #[ORM\Column(length: 80)]
    private ?string $location = null;

    #[ORM\OneToOne(mappedBy: 'device', targetEntity: Specification::class)]
    private ?Specification $specification;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Worker $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(string $os): self
    {
        $this->os = $os;

        return $this;
    }

    public function getOsType(): ?string
    {
        return $this->os_type;
    }

    public function setOsType(string $os_type): self
    {
        $this->os_type = $os_type;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function setIpAddress(string $ip_address): self
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getUser(): ?Worker
    {
        return $this->user;
    }

    public function setUser(?Worker $worker): self
    {
        $this->user = $worker;

        return $this;
    }

    /**
     * @return Specification|null
     */
    public function getSpecification(): ?Specification
    {
        return $this->specification;
    }


}
