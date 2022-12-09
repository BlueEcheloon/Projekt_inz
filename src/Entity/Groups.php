<?php

namespace App\Entity;

use App\Repository\GroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupsRepository::class)]
class Groups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'ad_group', targetEntity: Worker::class)]
    private Collection $workers;

    #[ORM\OneToMany(mappedBy: 'admin_group', targetEntity: Admin::class)]
    private Collection $admins;

    public function __construct()
    {
        $this->workers = new ArrayCollection();
        $this->admins = new ArrayCollection();
    }

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
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Worker>
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(Worker $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers->add($worker);
            $worker->setAdGroupWork($this);
        }

        return $this;
    }

    public function removeWorker(Worker $worker): self
    {
        if ($this->workers->removeElement($worker)) {
            // set the owning side to null (unless already changed)
            if ($worker->getAdGroupWork() === $this) {
                $worker->setAdGroupWork(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Admin>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins->add($admin);
            $admin->setAdminGroup($this);
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getAdminGroup() === $this) {
                $admin->setAdminGroup(null);
            }
        }

        return $this;
    }
}
