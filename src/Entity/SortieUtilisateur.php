<?php

namespace App\Entity;

use App\Repository\SortieUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieUtilisateurRepository::class)
 */
class SortieUtilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Sortie::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sortie_id;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur_id;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSortieId(): ?Sortie
    {
        return $this->sortie_id;
    }

    public function setSortieId(Sortie $sortie_id): self
    {
        $this->sortie_id = $sortie_id;

        return $this;
    }

    public function getUtilisateurId(): ?Utilisateur
    {
        return $this->utilisateur_id;
    }

    public function setUtilisateurId(Utilisateur $utilisateur_id): self
    {
        $this->utilisateur_id = $utilisateur_id;

        return $this;
    }

}
