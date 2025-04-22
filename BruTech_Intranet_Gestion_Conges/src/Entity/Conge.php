<?php

namespace App\Entity;

use App\Repository\ongeRepository;
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

    // Getters/Setters...
}