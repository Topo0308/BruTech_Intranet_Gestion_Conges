<?php

namespace App\Entity;

use App\Repository\HistoriqueCongeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueCongeRepository::class)]
class HistoriqueConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $actionConge = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detailConge = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creationHistorique = null;

    #[ORM\ManyToOne(inversedBy: 'HistoriqueConge')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userHistorique = null;

    #[ORM\ManyToOne(inversedBy: 'Historique')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conge $congeHistorique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionConge(): ?string
    {
        return $this->actionConge;
    }

    public function setActionConge(string $actionConge): static
    {
        $this->actionConge = $actionConge;

        return $this;
    }

    public function getDetailConge(): ?string
    {
        return $this->detailConge;
    }

    public function setDetailConge(?string $detailConge): static
    {
        $this->detailConge = $detailConge;

        return $this;
    }

    public function getCreationHistorique(): ?\DateTimeImmutable
    {
        return $this->creationHistorique;
    }

    public function setCreationHistorique(\DateTimeImmutable $creationHistorique): static
    {
        $this->creationHistorique = $creationHistorique;

        return $this;
    }

    public function getUserHistorique(): ?User
    {
        return $this->userHistorique;
    }

    public function setUserHistorique(?User $userHistorique): static
    {
        $this->userHistorique = $userHistorique;

        return $this;
    }

    public function getCongeHistorique(): ?Conge
    {
        return $this->congeHistorique;
    }

    public function setCongeHistorique(?Conge $congeHistorique): static
    {
        $this->congeHistorique = $congeHistorique;

        return $this;
    }
}
