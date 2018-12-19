<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $odd_a;

    /**
     * @ORM\Column(type="float")
     */
    private $odd_b;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $round;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tournament", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player_a;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player_b;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     */
    private $player_won;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $favorite_won;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOddA(): ?float
    {
        return $this->odd_a;
    }

    public function setOddA(float $odd_a): self
    {
        $this->odd_a = $odd_a;

        return $this;
    }

    public function getOddB(): ?float
    {
        return $this->odd_b;
    }

    public function setOddB(float $odd_b): self
    {
        $this->odd_b = $odd_b;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getRound(): ?string
    {
        return $this->round;
    }

    public function setRound(string $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getPlayerA(): ?Player
    {
        return $this->player_a;
    }

    public function setPlayerA(Player $player_a): self
    {
        $this->player_a = $player_a;

        return $this;
    }

    public function getPlayerB(): ?Player
    {
        return $this->player_b;
    }

    public function setPlayerB(Player $player_b): self
    {
        $this->player_b = $player_b;

        return $this;
    }

    public function getPlayerWon(): ?Player
    {
        return $this->player_won;
    }

    public function setPlayerWon(?Player $player_won): self
    {
        $this->player_won = $player_won;

        return $this;
    }

    public function getFavoriteWon(): ?bool
    {
        return $this->favorite_won;
    }

    public function setFavoriteWon(?bool $favorite_won): self
    {
        $this->favorite_won = $favorite_won;

        return $this;
    }
}
