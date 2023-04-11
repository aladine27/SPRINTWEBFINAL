<?php

namespace App\Entity;

use App\Repository\VotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VotesRepository::class)]
class Votes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $VoteA = null;

    #[ORM\Column]
    private ?float $VoteE = null;

    #[ORM\OneToOne(inversedBy: 'votes', cascade: ['persist',])]
    private ?User $IdC = null;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoteA(): ?float
    {
        return $this->VoteA;
    }

    public function setVoteA(float $VoteA): self
    {
        $this->VoteA = $VoteA;

        return $this;
    }

    public function getVoteE(): ?float
    {
        return $this->VoteE;
    }

    public function setVoteE(float $VoteE): self
    {
        $this->VoteE = $VoteE;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getIdC(): ?User
    {
        return $this->IdC;
    }

    public function setIdC(?User $IdC): self
    {
        $this->IdC = $IdC;

        return $this;
    }
}
