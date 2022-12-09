<?php

namespace App\Entity;

use App\Repository\SpecificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecificationRepository::class)]
class Specification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $device = null;

    #[ORM\Column(length: 20)]
    private ?string $os_version = null;

    #[ORM\Column(length: 30)]
    private ?string $memory = null;

    #[ORM\Column(length: 50)]
    private ?string $processor = null;

    #[ORM\Column(length: 50)]
    private ?string $motherboard = null;

    #[ORM\Column(length: 60)]
    private ?string $graphics = null;

    #[ORM\Column(length: 40)]
    private ?string $harddisk = null;

    #[ORM\Column(length: 80)]
    private ?string $antivirus = null;

    #[ORM\Column(length: 20)]
    private ?string $serial_number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_purchase = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $warranty_exp = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getOsVersion(): ?string
    {
        return $this->os_version;
    }

    public function setOsVersion(string $os_version): self
    {
        $this->os_version = $os_version;

        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(string $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getMotherboard(): ?string
    {
        return $this->motherboard;
    }

    public function setMotherboard(string $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }

    public function getGraphics(): ?string
    {
        return $this->graphics;
    }

    public function setGraphics(string $graphics): self
    {
        $this->graphics = $graphics;

        return $this;
    }

    public function getHarddisk(): ?string
    {
        return $this->harddisk;
    }

    public function setHarddisk(string $harddisk): self
    {
        $this->harddisk = $harddisk;

        return $this;
    }

    public function getAntivirus(): ?string
    {
        return $this->antivirus;
    }

    public function setAntivirus(string $antivirus): self
    {
        $this->antivirus = $antivirus;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $serial_number): self
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getDateOfPurchase(): ?\DateTimeInterface
    {
        return $this->date_of_purchase;
    }

    public function setDateOfPurchase(\DateTimeInterface $date_of_purchase): self
    {
        $this->date_of_purchase = $date_of_purchase;

        return $this;
    }

    public function getWarrantyExp(): ?\DateTimeInterface
    {
        return $this->warranty_exp;
    }

    public function setWarrantyExp(\DateTimeInterface $warranty_exp): self
    {
        $this->warranty_exp = $warranty_exp;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
