<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEmbauche = null;

    #[ORM\Column(length: 50)]
    private ?string $manager = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'creationUser')]
    private ?self $managers = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'managers')]
    private Collection $creationUser;

    #[ORM\Column]
    private ?\DateTimeImmutable $miseAjourUser = null;

    /**
     * @var Collection<int, Conge>
     */
    #[ORM\OneToMany(targetEntity: Conge::class, mappedBy: 'utilisateur')]
    private Collection $conges;

    /**
     * @var Collection<int, HistoriqueConge>
     */
    #[ORM\OneToMany(targetEntity: HistoriqueConge::class, mappedBy: 'userHistorique', orphanRemoval: true)]
    private Collection $HistoriqueConge;

    public function __construct()
    {
        $this->creationUser = new ArrayCollection();
        $this->conges = new ArrayCollection();
        $this->HistoriqueConge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTimeInterface $dateEmbauche): static
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    public function getManagers(): ?self
    {
        return $this->managers;
    }

    public function setManagers(?self $managers): static
    {
        $this->managers = $managers;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCreationUser(): Collection
    {
        return $this->creationUser;
    }

    public function addCreationUser(self $creationUser): static
    {
        if (!$this->creationUser->contains($creationUser)) {
            $this->creationUser->add($creationUser);
            $creationUser->setManagers($this);
        }

        return $this;
    }

    public function removeCreationUser(self $creationUser): static
    {
        if ($this->creationUser->removeElement($creationUser)) {
            // set the owning side to null (unless already changed)
            if ($creationUser->getManagers() === $this) {
                $creationUser->setManagers(null);
            }
        }

        return $this;
    }

    public function getMiseAjourUser(): ?\DateTimeImmutable
    {
        return $this->miseAjourUser;
    }

    public function setMiseAjourUser(\DateTimeImmutable $miseAjourUser): static
    {
        $this->miseAjourUser = $miseAjourUser;

        return $this;
    }

    /**
     * @return Collection<int, Conge>
     */
    public function getConges(): Collection
    {
        return $this->conges;
    }

    public function addConge(Conge $conge): static
    {
        if (!$this->conges->contains($conge)) {
            $this->conges->add($conge);
            $conge->setUtilisateur($this);
        }

        return $this;
    }

    public function removeConge(Conge $conge): static
    {
        if ($this->conges->removeElement($conge)) {
            // set the owning side to null (unless already changed)
            if ($conge->getUtilisateur() === $this) {
                $conge->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueConge>
     */
    public function getHistoriqueConge(): Collection
    {
        return $this->HistoriqueConge;
    }

    public function addHistoriqueConge(HistoriqueConge $historiqueConge): static
    {
        if (!$this->HistoriqueConge->contains($historiqueConge)) {
            $this->HistoriqueConge->add($historiqueConge);
            $historiqueConge->setUserHistorique($this);
        }

        return $this;
    }

    public function removeHistoriqueConge(HistoriqueConge $historiqueConge): static
    {
        if ($this->HistoriqueConge->removeElement($historiqueConge)) {
            // set the owning side to null (unless already changed)
            if ($historiqueConge->getUserHistorique() === $this) {
                $historiqueConge->setUserHistorique(null);
            }
        }

        return $this;
    }
}
