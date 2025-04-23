<?php

namespace App\Entity;

use App\Repository\ongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente une demande de congé dans le système
 */
#[ORM\Entity(repositoryClass: CongeRepository::class)]
class Conge
{
    // Statuts possibles
    public const STATUT_EN_ATTENTE = 'EN_ATTENTE';
    public const STATUT_VALIDE = 'VALIDE';
    public const STATUT_REFUSE = 'REFUSE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: 'integer')]
    private ?int $joursDemandes = null;

    #[ORM\Column(length: 20)]
    private string $statut = self::STATUT_EN_ATTENTE;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'conges')]
    private ?User $utilisateur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebutConge = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinConge = null;

    #[ORM\Column(length: 255)]
    private ?string $modifierConge = null;

    #[ORM\Column(length: 20)]
    private ?string $typeConge = null;

    #[ORM\Column(length: 20)]
    private ?string $statusConge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $justificationConge = null;

    #[ORM\Column(length: 29)]
    private ?string $tailleJustificationConge = null;

    #[ORM\Column(nullable: true)]
    private ?int $justicationCongeDoc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireEmploye = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireManager = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creationConge = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $miseAjourConge = null;

    /**
     * @var Collection<int, HistoriqueConge>
     */
    #[ORM\OneToMany(targetEntity: HistoriqueConge::class, mappedBy: 'congeHistorique', orphanRemoval: true)]
    private Collection $Historique;

    public function __construct()
    {
        $this->Historique = new ArrayCollection();
    }

    // Getters/Setters...

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDateDebutConge(): ?\DateTimeInterface
    {
        return $this->dateDebutConge;
    }

    public function setDateDebutConge(\DateTimeInterface $dateDebutConge): static
    {
        $this->dateDebutConge = $dateDebutConge;

        return $this;
    }

    public function getDateFinConge(): ?\DateTimeInterface
    {
        return $this->dateFinConge;
    }

    public function setDateFinConge(\DateTimeInterface $dateFinConge): static
    {
        $this->dateFinConge = $dateFinConge;

        return $this;
    }

    public function getModifierConge(): ?string
    {
        return $this->modifierConge;
    }

    public function setModifierConge(string $modifierConge): static
    {
        $this->modifierConge = $modifierConge;

        return $this;
    }

    public function getTypeConge(): ?string
    {
        return $this->typeConge;
    }

    public function setTypeConge(string $typeConge): static
    {
        $this->typeConge = $typeConge;

        return $this;
    }

    public function getStatusConge(): ?string
    {
        return $this->statusConge;
    }

    public function setStatusConge(string $statusConge): static
    {
        $this->statusConge = $statusConge;

        return $this;
    }

    public function getJustificationConge(): ?string
    {
        return $this->justificationConge;
    }

    public function setJustificationConge(?string $justificationConge): static
    {
        $this->justificationConge = $justificationConge;

        return $this;
    }

    public function getTailleJustificationConge(): ?string
    {
        return $this->tailleJustificationConge;
    }

    public function setTailleJustificationConge(string $tailleJustificationConge): static
    {
        $this->tailleJustificationConge = $tailleJustificationConge;

        return $this;
    }

    public function getJusticationCongeDoc(): ?int
    {
        return $this->justicationCongeDoc;
    }

    public function setJusticationCongeDoc(?int $justicationCongeDoc): static
    {
        $this->justicationCongeDoc = $justicationCongeDoc;

        return $this;
    }

    public function getCommentaireEmploye(): ?string
    {
        return $this->commentaireEmploye;
    }

    public function setCommentaireEmploye(?string $commentaireEmploye): static
    {
        $this->commentaireEmploye = $commentaireEmploye;

        return $this;
    }

    public function getCommentaireManager(): ?string
    {
        return $this->commentaireManager;
    }

    public function setCommentaireManager(?string $commentaireManager): static
    {
        $this->commentaireManager = $commentaireManager;

        return $this;
    }

    public function getCreationConge(): ?\DateTimeImmutable
    {
        return $this->creationConge;
    }

    public function setCreationConge(\DateTimeImmutable $creationConge): static
    {
        $this->creationConge = $creationConge;

        return $this;
    }

    public function getMiseAjourConge(): ?\DateTimeImmutable
    {
        return $this->miseAjourConge;
    }

    public function setMiseAjourConge(\DateTimeImmutable $miseAjourConge): static
    {
        $this->miseAjourConge = $miseAjourConge;

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueConge>
     */
    public function getHistorique(): Collection
    {
        return $this->Historique;
    }

    public function addHistorique(HistoriqueConge $historique): static
    {
        if (!$this->Historique->contains($historique)) {
            $this->Historique->add($historique);
            $historique->setCongeHistorique($this);
        }

        return $this;
    }

    public function removeHistorique(HistoriqueConge $historique): static
    {
        if ($this->Historique->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getCongeHistorique() === $this) {
                $historique->setCongeHistorique(null);
            }
        }

        return $this;
    }
}