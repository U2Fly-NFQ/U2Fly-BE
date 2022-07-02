<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $path;

    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Account::class, cascade: ['persist', 'remove'])]
    private $account;

    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Airline::class, cascade: ['persist', 'remove'])]
    private $airline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        // set the owning side of the relation if necessary
        if ($account->getImage() !== $this) {
            $account->setImage($this);
        }

        $this->account = $account;

        return $this;
    }

    public function getAirline(): ?Airline
    {
        return $this->airline;
    }

    public function setAirline(Airline $airline): self
    {
        // set the owning side of the relation if necessary
        if ($airline->getImage() !== $this) {
            $airline->setImage($this);
        }

        $this->airline = $airline;

        return $this;
    }
}
